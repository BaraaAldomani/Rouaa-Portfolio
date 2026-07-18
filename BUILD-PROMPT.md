# Build prompt template — bilingual portfolio / marketing site

Distilled from two shipped sites (Baraa Aldomani — dark engineering register;
Rouaa Mahmoud — light "sky & glass" register). **Part 1 is what you fill in per
site. Part 2 is invariant — paste it verbatim.**

Replace every `«…»`. Delete nothing from Part 2.

---
---

# PART 1 — Fill this in

## 1. Who & why
- **Name:** «Full name, both scripts if bilingual — e.g. رؤى محمود / Rouaa Mahmoud»
- **Role / one-liner:** «e.g. business consultant, external auditor & Zakat specialist»
- **Location:** «e.g. Riyadh, Saudi Arabia»
- **Goal of the site:** «what it must make the visitor believe or do»
- **Audience:** «who scans this and what makes them trust it»
- **Tone:** «e.g. calm, precise, credible — not salesy»
- **Tagline:** «short line, both languages»

## 2. Source material
- **Content source:** «path to an existing HTML/PDF/doc, or "write it from the brief"»
- **Assets:** «logo files, photos — or "extract from the source file"»
- If the source has bilingual strings (e.g. `data-ar`/`data-en`), **inventory every
  one before coding** and preserve them verbatim.

## 3. Visual identity
- **Register:** «pick a lane and commit — e.g. "light, airy, frosted glass" or
  "near-black engineering blueprint". It must NOT look like the other sites.»
- **Brand colours (exactly 3):**
  - `--brand-primary`: «#hex — brand, links, CTAs»
  - `--brand-secondary`: «#hex — ink & dark sections»
  - `--brand-accent`: «#hex — highlights/glow»
- **Typography:** «display font + body font; Cairo for Arabic»
- **Signature motif:** «the one memorable element — e.g. rotating dashed rings
  around the logo, or a faint UML/git-graph watermark»
- **Motion character:** «e.g. calm and slow, or crisp and orchestrated»

## 4. Pages
«e.g. home · about · services · training · contact» — real routes under
`/{locale}`, not an SPA.

## 5. Content model
List each repeating content type and its fields. Everything bilingual gets
`*_ar`/`*_en`; everything ordered gets `sort_order`.

| Table | Fields | Source |
|---|---|---|
| «services» | «key, icon, title_*, summary_*, description_*, features_*(json)» | «services section» |
| «…» | | |

*Reference — Baraa used:* services, projects (case studies), experiences,
metrics, technologies, capabilities, process_steps, focus_items.
*Rouaa used:* services, training_series + courses, experiences,
education_items, skills, stats.

## 6. Dashboard-editable settings
Group singleton copy into settings groups (each becomes one admin page):
`theme` (3 colours) · `identity` · `pages` (inner-page headers) · `«per-page
groups»` · `contact` · `seo` · `images`.

## 7. Environment
- **Local ports** (must not collide with other sites on this machine):
  nginx `«8082»`, postgres `«5434»`, vite `«5175»`
- **Production:** «domain», Hostinger + MySQL 8, deploy path
  `/home/«user»/domains/«domain»/public_html`

---
---

# PART 2 — Invariant spec (paste verbatim)

## Stack
Laravel 13 · PHP 8.3 · Tailwind v4 · vanilla JS (no front-end framework) ·
Filament v4 admin at `/admin` · Docker for local dev · GitHub Actions → Hostinger.
**No new runtime dependencies** beyond these.

## Bilingual architecture
- Arabic (`ar`) is default and RTL; English (`en`) is LTR. Both first-class.
- Real routes under `/{locale}`; `/` → 301 → `/ar`.
- `SetLocale` middleware sets locale + `URL::defaults`.
- **Every** string exists in both languages. No exceptions.
- Use CSS **logical properties only** (`inset-inline-start`, `ms-*`, `text-start`)
  so RTL flips correctly. Never `left`/`right`.

## Content architecture — this is the core pattern
1. **Structural content lives in DB tables**, one per content type, with
   `{field}_ar` / `{field}_en` columns and `sort_order`.
2. Models are `final`, use a `HasLocalizedContent` trait providing
   `localized('title')`, `localizedArray('features')`, and an `ordered()` scope.
3. **Singleton copy lives in a `settings` table** — `group`, `key`, `value` (json),
   unique on `(group, key)`. Defaults live in ONE class (`App\Support\SettingsDefaults`)
   consumed by both the seeder and the Filament pages, so there is a single source
   of truth and no lang-file duplication.
4. A `SiteContent` service is the single read layer, shared into every view as
   `$site` via `View::share`.
   - The settings map (a plain array) is cached persistently.
   - Content collections are **memoised per-request only** — never cache Eloquent
     collections in the database cache store; they deserialize as
     `__PHP_Incomplete_Class`.
5. A `ContentObserver` on every content model + `Setting` flushes the cache on
   save/delete, so dashboard edits appear immediately.
6. Helpers: `setting()`, `setting_text()` (locale-aware), `setting_list()`,
   `image_url()` (uploaded → public disk, else falls back to a config default).
   Register via composer `autoload.files`.
7. **Lang files hold chrome only** — nav labels, form labels, buttons, aria
   strings. All real content is DB/settings driven.

## Design system — non-negotiable
- `resources/css/tokens.css` defines **exactly three** editable brand variables.
  Every other colour — full 50→950 ramps, surfaces, text, borders, glass tints,
  glows — derives from them via `color-mix(in oklab, …)`.
- `app.css` maps tokens → Tailwind utilities with `@theme inline`, and wipes the
  stock palette (`--color-*: initial`) so off-brand utilities cannot be used.
- **Blade never contains a raw hex value.** Only semantic utilities:
  `bg-surface`, `text-ink`, `text-muted`, `border-line`, `bg-primary`, `*-on-dark`.
- The dashboard's 3 theme colours are injected as an inline `<style>:root{…}</style>`
  **after** `@vite`, so changing them re-themes the entire site instantly.
- Contrast ≥ WCAG AA (4.5:1 body text). State it and check it.

## Motion
- One small vanilla JS file. IntersectionObserver scroll reveals with stagger,
  animated count-up stats, and the site's signature effect.
- Hidden states apply **only under `html.js`**, so content is fully visible
  without JS and to crawlers.
- Animate transform/opacity only.
- `prefers-reduced-motion: reduce` disables all decorative animation — in CSS
  *and* in JS (reveal instantly).

## Admin (Filament v4)
- Panel branded, primary colour = brand primary, English/LTR chrome via a
  `SetPanelLocale` middleware.
- Nav groups as **plain strings**: `Content`, `Settings`, `Inbox`
  (v4 conflicts if you mix group objects and item icons).
- Resources: one per content table, bilingual fields **side by side** in
  2-column sections, reorderable tables (`reorderable('sort_order')`),
  `TagsInput` for json arrays, `Select` for enums, relation managers for
  parent/child (e.g. series → courses).
- Settings pages extend one abstract `SettingsPage` base (group / defaultValues /
  formSchema / save + cache flush + notification).
- Inbox = read-only contact messages with a nav badge and an infolist view.
- Auth: `is_admin` boolean, `User implements FilamentUser::canAccessPanel`,
  plus an `app:create-admin` console command.

## SEO
`PageMeta` (settings-first, lang fallback) · per-page `<title>`/description ·
canonical · hreflang alternates + `x-default` · Open Graph · `sitemap.xml` with
`xhtml:link` alternates · `robots.txt` · JSON-LD `Person` with `sameAs`.

## Forms
Contact form posts to the DB (`contact_messages`: name, email, message, locale, ip)
with a honeypot field and a FormRequest. No SMTP required — messages surface in
the admin Inbox.

## Local environment (Docker)
Services: `app` (php:8.3-fpm-alpine + pdo_pgsql, pdo_mysql, intl, gd, zip, opcache),
`nginx`, `db` (postgres:16), `node` (vite dev server). Use the ports from Part 1
so multiple sites run simultaneously.

**Bake in these hard-won fixes from day one:**
- nginx: `location ^~ /livewire/ { try_files $uri /index.php?$query_string; }` —
  Filament serves some assets through PHP.
- Dev image: run FPM as root and disable OPcache (Windows bind-mount mtimes are
  unreliable); prod keeps OPcache.
- `composer.json`: pin `config.platform.php` to `8.3.x`. Resolving under PHP 8.4
  pulls Symfony 8, which then fatals on an 8.3 runtime.
- `.gitignore`: `public/{css,js,fonts}/filament`, and **all** `.env*` except
  `.env.example` and `.env.*.encrypted`.

## Deployment
GitHub Actions → rsync over SSH → Hostinger (MySQL 8). Required behaviours:
- Production env is **committed encrypted** (`env:encrypt`) and decrypted into
  `.env` on the server each deploy, so config ships through git and nobody edits
  `.env` over SSH.
- Purge `bootstrap/cache/*.php` with **plain `rm`** before any artisan call — a
  stale cached config makes providers boot against outdated config and crash.
- Ordering: file-based clears (`config:clear`, `route:clear`, `view:clear`) →
  `migrate --force` → `cache:clear`. The DB-backed cache clear **must** come after
  migrate, or a fresh database fails on the missing `cache` table.
- Run `filament:assets` and `storage:link` on the server.
- `db:seed` and `app:create-admin` are **first-deploy only, by hand** — never in
  the pipeline, so dashboard edits are never overwritten.
- `PHP_BIN` must point at PHP 8.3 explicitly (shared-host default is 8.2).
- Document root → the app's `public/` directory.

## Execution phases — work in this order, verify before advancing
0. **Scaffold** — `composer create-project`, git init, Docker with the assigned
   ports, boot, confirm `/` returns 200. Extract any embedded assets.
1. **Infrastructure** — trait, `SiteContent`, helpers, observer, provider,
   `PageMeta`, middleware, routes, locales config, chrome lang files.
2. **Schema + seeders** — all tables/models/seeders with the full bilingual
   inventory. Migrate, seed, and **verify row counts** against the inventory.
3. **Design system + pages** — tokens, `@theme`, components, motion JS, layout,
   then each page reading from `$site`. Verify both locales render and RTL is correct.
4. **Admin** — Filament, resources, settings pages, inbox. **Browser-verify** a
   full CRUD round-trip and a theme recolour reaching the public site.
5. **Deploy wiring** — workflow, docs, `.env.example`, tests. Verify migrations
   and seeders on **MySQL** (production engine), not just the local Postgres.

## Verification — required before declaring done
- Every page × every locale returns 200; RTL and LTR both correct.
- Seeded row counts match the content inventory exactly.
- `sitemap.xml`, hreflang, and JSON-LD are valid.
- Contact submission lands in the admin Inbox.
- Editing content **and** the 3 theme colours in `/admin` changes the public site
  immediately.
- `php artisan test` green.
- Migrations + seeders verified on MySQL.
- All sites on the machine run simultaneously without port collisions.

## Hard constraints
- Bilingual parity — every string in both languages.
- Logical CSS properties only; RTL is a first-class layout, not a mirror hack.
- Content visible without JS; `prefers-reduced-motion` honoured; real alt/aria.
- WCAG AA contrast.
- No raw hex in Blade; no off-brand Tailwind colour utilities.
- No new runtime dependencies.
- Don't reuse another site's visual register — same architecture, different face.

---
---

# How to use this

1. Copy this file, fill in **Part 1**, keep **Part 2** as-is.
2. Hand the whole thing to the agent as the brief.
3. Ask it to inventory the source content **first**, then confirm the plan before coding.
4. Follow `deploy/RUNBOOK.md` when it's time to ship.
