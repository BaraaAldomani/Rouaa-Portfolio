# CI/CD secrets

Add these under **GitHub → Settings → Secrets and variables → Actions → New
repository secret**. The deploy workflow (`.github/workflows/deploy.yml`) reads
them to ship the build to Hostinger over SSH.

This account (`u744145577`, host `lt-bnk-web430`) hosts several sites under
`~/domains/`, so each site's app root is its own `public_html`:

```
/home/u744145577/domains/rouaa.rakeez-llc.com/public_html   ← this site
/home/u744145577/domains/baraa.rakeez-llc.com/public_html   ← sibling site
```

| Secret | Value / example | Notes |
|---|---|---|
| `SSH_PRIVATE_KEY` | `-----BEGIN OPENSSH PRIVATE KEY----- …` | Full private key. Add the matching public key to the server's `~/.ssh/authorized_keys`. |
| `SSH_HOST` | your server IP / hostname | From hPanel → SSH access. |
| `SSH_USER` | `u744145577` | Hostinger SSH user. |
| `SSH_PORT` | `65002` | Hostinger shared hosting SSH port (not 22). |
| `DEPLOY_PATH` | `/home/u744145577/domains/rouaa.rakeez-llc.com/public_html` | The folder that will contain `artisan`. |
| `PHP_BIN` | `/opt/alt/php83/usr/bin/php` | **PHP 8.3** CLI path. On CloudLinux the default `php` is often 8.2 — set the full 8.3 path. Defaults to `php` if unset. Verify with `<path> -v`. |
| `LARAVEL_ENV_ENCRYPTION_KEY` | `base64:…` (32 random bytes) | **Optional but recommended.** Decrypts `.env.production.encrypted` into `.env` on every deploy, so production config ships through git instead of being hand-edited over SSH. Leave unset to keep managing `.env` manually on the server. See [`DEPLOY.md`](DEPLOY.md) §1c and §2b. |

> Do **not** upload anything to the domain folder itself (the level holding
> `DO_NOT_UPLOAD_HERE`) — only `public_html` is served.

## Generating a deploy key

```bash
ssh-keygen -t ed25519 -C "github-deploy-rouaa" -f deploy_key
# Add deploy_key.pub to the server:
#   cat deploy_key.pub >> ~/.ssh/authorized_keys   (on the server)
# Paste the contents of deploy_key (the private half) into SSH_PRIVATE_KEY.
```

The workflow strips CR characters from the pasted key and probes auth before
rsync, so a rejected key fails fast with a clear log line.

## Triggering

- Automatic: every push to `main` (or `master`).
- Manual: **Actions → Deploy to Hostinger → Run workflow**.

The first deploy still needs the one-time bootstrap in
[`DEPLOY.md`](DEPLOY.md) §1 (create DB, `.env`, seed, admin, storage:link).
