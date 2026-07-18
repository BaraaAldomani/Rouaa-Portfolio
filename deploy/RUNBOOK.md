# Deploy runbook — Laravel + Filament → Hostinger

A repeatable checklist for taking a new site live. Do the steps **in order** —
each one's verification is what makes the next one safe. Nothing here is
optional; every check exists because skipping it caused a real failure.

Placeholders: `<SITE>` = domain (e.g. `rouaa.rakeez-llc.com`),
`<USER>` = SSH user (e.g. `u744145577`), `<IP>` = server IP.

---

## Phase 0 — Collect these before starting

| Value | Where |
|---|---|
| Server IP + SSH port | hPanel → Advanced → SSH Access (port is **65002**, not 22) |
| SSH username | same page (`uXXXXXXXXX`) |
| PHP 8.3 CLI path | usually `/opt/alt/php83/usr/bin/php` |
| MySQL name / user / password | hPanel → Databases → MySQL (**prefixed**, e.g. `uXXXXXXXXX_site`) |

---

## Phase 1 — SSH key

**1.1** Generate **locally** (never on the server), no passphrase — CI cannot type one:

```bash
ssh-keygen -t ed25519 -C "github-deploy-<SITE>" -f ~/.ssh/<SITE>_deploy -N ""
```

**1.2** Install the **public** half: hPanel → Advanced → SSH Access → SSH Keys → Add key.
Paste the contents of `~/.ssh/<SITE>_deploy.pub` (one line).

> Use the hPanel UI, not `>>` on the server — a stray `>` wipes other sites' keys.

**1.3 ✓ Verify — do not continue until this prints `SSH_OK`:**

```bash
ssh -p 65002 -i ~/.ssh/<SITE>_deploy -o IdentitiesOnly=yes -o BatchMode=yes \
  <USER>@<IP> 'echo SSH_OK; whoami; pwd'
```

`IdentitiesOnly=yes` is **mandatory** — without it SSH may authenticate with a
different key you own and give a false pass while CI still fails.

---

## Phase 2 — Server prep

**2.1 ✓ Confirm the PHP 8.3 binary** (the default `php` is 8.2 and will fail):

```bash
ssh -p 65002 -i ~/.ssh/<SITE>_deploy <USER>@<IP> '/opt/alt/php83/usr/bin/php -v'
```

Must report **8.3.x**.

**2.2 ✓ Confirm the deploy path exists:**

```bash
ssh -p 65002 -i ~/.ssh/<SITE>_deploy <USER>@<IP> 'ls -d ~/domains/<SITE>/public_html'
```

**2.3 ✓ Confirm the database accepts the credentials:**

```bash
ssh -p 65002 -i ~/.ssh/<SITE>_deploy <USER>@<IP> \
  'mysql -h localhost -u <DB_USER> -p<DB_PASS> <DB_NAME> -e "SELECT VERSION();"'
```

No space after `-p`. A version string = `DB_HOST=localhost` is correct.
`[2002] No such file or directory` = use `127.0.0.1` instead.

**2.4 Document root** — hPanel → Domains → `<SITE>` → Document Root →
`public_html/public`.

*If your plan won't allow it:* copy `deploy/root.htaccess` to
`public_html/.htaccess` instead. Skipping both gives **403 Forbidden**, because
the app root has no `index.php`.

---

## Phase 3 — Production environment

**3.1** Create `.env.production` locally (git-ignored). Critical values:

```dotenv
APP_ENV=production
APP_DEBUG=false
APP_URL=https://<SITE>          # NOT localhost
APP_KEY=                        # fill from 3.2 — set once, never change
DB_CONNECTION=mysql             # NOT pgsql
DB_HOST=localhost
DB_PORT=3306                    # MySQL's port, NOT the SSH port
DB_DATABASE=uXXXXXXXXX_site     # prefixed
DB_USERNAME=uXXXXXXXXX_site     # prefixed
DB_PASSWORD=…
ADMIN_EMAIL=…                   # must be non-empty
ADMIN_PASSWORD=…                # must be non-empty
LOG_LEVEL=error
# SESSION_SECURE_COOKIE=true    # only AFTER HTTPS is confirmed live
```

**3.2** Generate the app key and paste it in:

```bash
docker compose exec app php artisan key:generate --show
```

**3.3 ✓ Sanity check before encrypting:**

```bash
grep -nE "CHANGE_ME|pgsql|localhost:8081|APP_DEBUG=true" .env.production
```

Must return **nothing**.

**3.4** Encrypt — first time lets Laravel mint the key and **print** it:

```bash
docker compose exec app php artisan env:encrypt --env=production
```

**Save that key.** Every later re-encrypt must reuse it:

```bash
docker compose exec app php artisan env:encrypt --env=production \
  --key="base64:YOUR_KEY" --force
```

> `env:encrypt` only honours `--key` — it **ignores** `LARAVEL_ENV_ENCRYPTION_KEY`.
> Omit it and you silently get a *new* key, and the next deploy fails with
> "The MAC is invalid."

**3.5** Commit `.env.production.encrypted` (the plaintext is git-ignored).

---

## Phase 4 — GitHub secrets

Settings → Secrets and variables → Actions. All seven:

| Secret | Value |
|---|---|
| `SSH_HOST` | `<IP>` |
| `SSH_USER` | `<USER>` |
| `SSH_PORT` | `65002` |
| `SSH_PRIVATE_KEY` | `clip < ~/.ssh/<SITE>_deploy` → paste, **incl. BEGIN/END lines** |
| `DEPLOY_PATH` | `/home/<USER>/domains/<SITE>/public_html` |
| `PHP_BIN` | `/opt/alt/php83/usr/bin/php` |
| `LARAVEL_ENV_ENCRYPTION_KEY` | the key from 3.4 |

`PHP_BIN` is **not optional** — unset means `php`, which is 8.2, and Laravel 13
requires 8.3+.

---

## Phase 5 — Deploy

**5.1** `git push` — the pipeline rsyncs, decrypts `.env`, clears caches,
migrates, publishes Filament assets, links storage, re-caches config/routes/views.

**5.2** One-time bootstrap (the pipeline never seeds, so dashboard edits are
never overwritten):

```bash
ssh -p 65002 -i ~/.ssh/<SITE>_deploy <USER>@<IP>
cd ~/domains/<SITE>/public_html
PHP_BIN=/opt/alt/php83/usr/bin/php

$PHP_BIN artisan db:seed --force
$PHP_BIN artisan app:create-admin
$PHP_BIN artisan storage:link
rm -f default.php                  # Hostinger placeholder — shadows the site
```

**5.3 Purge the CDN cache** — hPanel → Advanced → Cache Manager → Purge All
(and Performance → CDN → Purge).

Skip this and the previous site's cached homepage keeps being served for up to
**7 days**, even though your server is responding correctly.

---

## Phase 6 — Verify

```bash
curl -sI https://<SITE>/            | head -1   # 301 → /ar
curl -sI https://<SITE>/.env        | head -1   # 403/404  ← security
curl -sI https://<SITE>/composer.json | head -1 # 403/404
```

In a browser:

- [ ] `/ar` renders, RTL correct
- [ ] `/en` renders, LTR correct
- [ ] `/ar/services`, `/ar/training`, `/ar/about`, `/ar/contact`
- [ ] `/sitemap.xml`
- [ ] `/admin` login works
- [ ] Contact form submits → appears in admin Inbox
- [ ] Theme colour change in Settings → site recolours

---

## Ongoing changes

| To change | How | Deploy? |
|---|---|---|
| Content, SEO, colours, images | `/admin` dashboard | no — instant |
| Code | `git push` | automatic |
| Config (DB, mail, admin) | edit `.env.production` → re-encrypt **with the same key** → push | automatic |

---

## Troubleshooting — every error we actually hit

| Symptom | Cause | Fix |
|---|---|---|
| `Permission denied (publickey)` | public key not installed, or wrong key in secret | Phase 1.2; compare `ssh-keygen -lf` fingerprints both sides |
| Local SSH works, CI fails | secret truncated / wrong key | re-paste with `clip <`, include BEGIN/END |
| `require PHP >= 8.3.0, running 8.2.31` | `PHP_BIN` unset | set it (Phase 4) |
| `Table '<db>.cache' doesn't exist` | cache clear ran before migrate on empty DB | fixed in workflow; else run `migrate --force` once by hand |
| `403 Forbidden` | document root at app root, no `index.php` | Phase 2.4 |
| `The MAC is invalid` | re-encrypted without `--key` → new key | re-encrypt with the saved key |
| `SQLSTATE[2002] No such file or directory` | socket path mismatch | `DB_HOST=127.0.0.1` |
| `Access denied` for DB | forgot the `uXXXXXXXXX_` prefix | copy exactly from hPanel |
| Homepage shows an old/other site | stale CDN cache | Phase 5.3 |
| Can't log into `/admin` | `SESSION_SECURE_COOKIE=true` without HTTPS | comment it out, re-encrypt, push |
| `app:create-admin` fails | `ADMIN_EMAIL`/`ADMIN_PASSWORD` empty | empty ≠ unset — set real values |

---

## The five that bite hardest

1. **`PHP_BIN`** — default `php` is 8.2. Always set it.
2. **`IdentitiesOnly=yes`** when testing SSH, or you get a false pass.
3. **Document root → `public/`**, or 403.
4. **Re-encrypt with `--key`**, or the key silently rotates.
5. **Purge the CDN**, or you debug a site that's already working.
