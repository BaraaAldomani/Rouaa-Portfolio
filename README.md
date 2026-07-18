# Rouaa Mahmoud — Portfolio

Bilingual (Arabic-first RTL / English) portfolio for **Rouaa Mahmoud** —
business consultant, external auditor & Zakat specialist, TOT-certified trainer
and Rakeez co-founder in Riyadh. Every piece of content is editable from a
Filament dashboard at `/admin`, including the three brand colours.

- **Stack:** Laravel 13 · PHP 8.3 · Tailwind v4 · vanilla JS · Filament v4
- **Design:** "Sky & Glass" — a light, calm, frosted-glass identity in her
  brand blue `#1B9BD2`, with soft parallax orbs and gentle motion.
- **Pages:** `/{locale}` home · `/about` · `/services` · `/training` · `/contact`
  (real routes, not an SPA). `ar` is the default; `/` → `/ar`.

## Local development (Docker)

```bash
cp .env.example .env
docker compose up -d --build          # nginx :8081, postgres :5433, vite :5174
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate --seed
docker compose exec app php artisan app:create-admin \
  --email=you@example.com --password=secret
```

Then open:

- Public site → <http://localhost:8081> (redirects to `/ar`)
- Admin → <http://localhost:8081/admin>

Ports are deliberately offset (8081 / 5433 / 5174) so this site can run
alongside the sibling "Baraa" site (8080 / 5432 / 5173) at the same time.

## How content works

- Structural content (services, training series & courses, experience,
  education, skills, stats) lives in dedicated tables, edited via Filament
  resources, and is read on the front-end through the cached `$site`
  (`App\Support\SiteContent`).
- Page copy, links, SEO and the brand colours live in the `settings` table,
  edited via the Filament **Settings** pages. Defaults come from
  `App\Support\SettingsDefaults` (also what `SettingsSeeder` seeds).
- Saving anything in the dashboard flushes the content cache
  (`App\Observers\ContentObserver`), so edits appear on the site immediately.
- All colours derive from three CSS variables via `color-mix()`
  (`resources/css/tokens.css`); the dashboard injects them at
  `<style>:root{…}</style>`, so changing the three brand colours re-themes the
  whole site.

## Tests

```bash
docker compose exec app php artisan test
```

## Deployment

Push to `main` → GitHub Actions builds and deploys to Hostinger (MySQL 8).
See [`deploy/DEPLOY.md`](deploy/DEPLOY.md) and [`deploy/CICD.md`](deploy/CICD.md).
