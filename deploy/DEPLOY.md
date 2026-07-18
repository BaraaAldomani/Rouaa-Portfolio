# Deploying the Rouaa Mahmoud website

The site is a standard Laravel 13 + Filament v4 app. Pushing to `main`
triggers [`.github/workflows/deploy.yml`](../.github/workflows/deploy.yml),
which builds on GitHub's runners and rsyncs the result to Hostinger over SSH.

Local development runs on Docker (Postgres); **production runs on MySQL 8**
(Hostinger). Both are verified — migrations and seeders are engine-agnostic.

---

## 1. One-time server setup (before the first deploy)

Do these once, by hand, over SSH. They are intentionally **not** in the
pipeline so later deploys never overwrite content edited in the dashboard.

### a. Create the database (Hostinger hPanel → Databases → MySQL)
Note the DB name, user, and password.

### b. Point the document root at `public/`

The app deploys to this account's per-domain folder:

```
DEPLOY_PATH=/home/u744145577/domains/rouaa.rakeez-llc.com/public_html
```

**Preferred:** hPanel → **Domains → rouaa.rakeez-llc.com → Document Root** → set
it to `public_html/public`. This keeps `.env`, `vendor/` and `storage/` outside
the web root and is the most secure option.

**If the plan won't let you change it:** copy `deploy/root.htaccess` to
`public_html/.htaccess`. It forwards every request into `public/` and
explicitly denies `.env`, `storage/`, `vendor/` and other app internals.
Changing the document root is still preferable when possible.

> Verify either way: `https://rouaa.rakeez-llc.com/.env` must return 403/404.

### c. Build the encrypted production env (done **locally**, shipped by git)

Production config is **not** hand-edited on the server. You keep a plaintext
`.env.production` on your machine (git-ignored), commit only its AES-256
encrypted form, and the pipeline decrypts it into `.env` on every deploy.

**1. Create `.env.production` locally** (never committed):

```dotenv
APP_NAME="Rouaa Mahmoud"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://rouaa.rakeez-llc.com
APP_KEY=                # generate once (see step 2) and then NEVER change it

APP_LOCALE=en           # public site is Arabic-first via routing (/ → /ar)
APP_FALLBACK_LOCALE=en

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_db
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

# Used once by app:create-admin.
ADMIN_EMAIL=rouaa@example.com
ADMIN_PASSWORD=a-strong-password
ADMIN_NAME="Rouaa Mahmoud"

CACHE_STORE=database
SESSION_DRIVER=database
QUEUE_CONNECTION=database
MAIL_MAILER=log
```

**2. Generate a stable `APP_KEY`** and paste it into `.env.production`:

```bash
docker compose exec app php artisan key:generate --show
```

> ⚠️ `APP_KEY` encrypts sessions and any encrypted DB values. Set it once and
> keep it forever — changing it later logs everyone out and breaks encrypted data.

**3. Encrypt it.** The first time, let Laravel mint the key — it prints it:

```bash
docker compose exec app php artisan env:encrypt --env=production
```

```
Environment successfully encrypted.
  Key ............................. base64:XkX9x…      ← SAVE THIS
  Cipher .......................... AES-256-CBC
  Encrypted file .................. .env.production.encrypted
```

Store that key in your password manager — it is the only thing that can
decrypt the bundle. For every later re-encrypt, pass the **same** key so the
GitHub secret stays valid:

```bash
docker compose exec app php artisan env:encrypt --env=production \
  --key="base64:YOUR_KEY" --force
```

> ⚠️ `env:encrypt` only honours `--key`; it **ignores** `LARAVEL_ENV_ENCRYPTION_KEY`.
> Omit `--key` on a re-encrypt and it silently mints a *new* random key, and the
> next deploy fails with "The MAC is invalid." (`env:decrypt` does read the env
> var — that is what the pipeline uses.)

This writes **`.env.production.encrypted`** — commit that file. The plaintext
`.env.production` is blocked by `.gitignore`.

**4. Add the key as a GitHub secret** named `LARAVEL_ENV_ENCRYPTION_KEY`.

On every deploy the pipeline runs `env:decrypt` on the server and moves the
result to `.env` (mode 600), backing up the previous one to `.env.backup`.
If the secret is absent, the pipeline leaves the server's `.env` untouched.

> `PHP_BIN` below is the path to **PHP 8.3** CLI. On Hostinger/CloudLinux this
> is usually `/opt/alt/php83/usr/bin/php` (the default `php` may be 8.2). Use
> the same binary you set in the `PHP_BIN` GitHub secret.

### d. First-time bootstrap (run once, after the first deploy has rsynced files)

```bash
cd /home/u744145577/domains/rouaa.rakeez-llc.com/public_html
PHP_BIN=/opt/alt/php83/usr/bin/php

# .env already exists — the pipeline decrypted it. No key:generate needed.
$PHP_BIN artisan migrate --force
$PHP_BIN artisan db:seed --force        # initial bilingual content + settings
$PHP_BIN artisan app:create-admin       # reads ADMIN_EMAIL / ADMIN_PASSWORD
$PHP_BIN artisan storage:link
$PHP_BIN artisan filament:assets
```

Then visit `/admin` and sign in. Every page's text, the 4 services, 12
courses, timeline, stats, links, SEO, and the 3 brand colours are editable
there.

---

## 2. Ongoing deploys

Just push to `main`. The pipeline (see the workflow file) will:

1. `composer install --no-dev` and `npm run build` on the runner.
2. `rsync` everything except `.env`, `.git`, `node_modules`, `tests`,
   `deploy`, and volatile `storage/` caches (so server `.env` and uploaded
   images survive).
3. On the server: `rm` the stale `bootstrap/cache/*.php` (a plain delete, so no
   framework boot against poisoned config), then `optimize:clear`,
   `migrate --force`, `filament:assets`, `storage:link`, and re-cache
   config/routes/views.

`db:seed` and `app:create-admin` are **not** re-run by the pipeline — content
lives in the database and is managed from `/admin`.

---

## 2b. Changing an environment value (no SSH needed)

This is the whole point of the encrypted env: you never open the server to
edit config. Full loop, all local:

```bash
# 1. Decrypt to plaintext (only if you don't still have .env.production locally)
docker compose exec app php artisan env:decrypt --env=production \
  --key="base64:YOUR_KEY" --force

# 2. Edit .env.production in your editor (it is git-ignored)

# 3. Re-encrypt
docker compose exec app php artisan env:encrypt --env=production \
  --key="base64:YOUR_KEY" --force

# 4. Ship it
git add .env.production.encrypted
git commit -m "env: update production config"
git push
```

The push triggers a deploy, which decrypts the new bundle into `.env`,
clears the caches and re-caches config — so the change is live automatically.

**Notes**

- `.env.production.encrypted` is the single source of truth. Any manual edit
  made directly on the server is overwritten on the next deploy (by design).
- The previous `.env` is kept at `.env.backup` on the server for one deploy.
- **Rotating the encryption key:** re-encrypt with a new key, update the
  `LARAVEL_ENV_ENCRYPTION_KEY` secret, then push. Do both, or the deploy fails
  to decrypt.
- **Losing the key** is recoverable: rebuild `.env.production` by hand, encrypt
  with a fresh key, update the secret, push.
- ⚠️ **Keep this repository private.** The bundle is AES-256-CBC encrypted, so
  it is safe at rest, but a public repo hands an attacker the ciphertext
  permanently — if the key ever leaks, every secret in it is exposed. If the
  repo is or becomes public, rotate `APP_KEY`, the DB password, and the admin
  password immediately.

---

## 3. Secrets

See [`CICD.md`](CICD.md) for the required GitHub Actions secrets.
