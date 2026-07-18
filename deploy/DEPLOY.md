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

### c. Create `.env` on the server
Copy `.env.example` to `.env` and fill in production values:

```dotenv
APP_NAME="Rouaa Mahmoud"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com
APP_KEY=            # generate: php artisan key:generate

APP_LOCALE=en          # public site is Arabic-first via routing (/ → /ar)
APP_FALLBACK_LOCALE=en

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_db
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

# Used once by app:create-admin below.
ADMIN_EMAIL=rouaa@example.com
ADMIN_PASSWORD=a-strong-password
ADMIN_NAME="Rouaa Mahmoud"

CACHE_STORE=database
SESSION_DRIVER=database
QUEUE_CONNECTION=database
MAIL_MAILER=log
```

> `PHP_BIN` below is the path to **PHP 8.3** CLI. On Hostinger/CloudLinux this
> is usually `/opt/alt/php83/usr/bin/php` (the default `php` may be 8.2). Use
> the same binary you set in the `PHP_BIN` GitHub secret.

### d. First-time bootstrap (run once, after the first deploy has rsynced files)

```bash
cd ~/public_html            # your DEPLOY_PATH
PHP_BIN=/opt/alt/php83/usr/bin/php

$PHP_BIN artisan key:generate           # only if APP_KEY is empty
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

## 3. Secrets

See [`CICD.md`](CICD.md) for the required GitHub Actions secrets.
