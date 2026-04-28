# SalesForge — AI Sales Page Generator

**Submitted by**: Anashrul Yusuf
**Task option**: B — AI Sales Page Generator
**Deadline**: 30 April 2026
**Submission date**: {{ date('Y-m-d') }}

---

## Live URL

**https://ai-sales-page-ixxfhjy2za-et.a.run.app**

Hosted on Google Cloud Run · Cloud SQL Postgres · Region: `asia-southeast2` (Jakarta).

## Source code

**https://github.com/annashrul/sales-forge**

## Video walkthrough

**[YOUTUBE LINK — TO BE FILLED IN]**

---

## What it does

A web app that turns raw product information into a complete, styled, persuasive sales page.

User flow:
1. Register / sign in
2. Fill a structured form: product name, description, key features, target audience, price, USPs, tone, design template
3. AI drafts the page in ~30 seconds — headline, sub-headline, description, benefits, features breakdown, social proof, pricing, call-to-action
4. Live-preview the page in one of three design templates (Modern dark, Classic editorial, Bold sticker)
5. Save, edit-regenerate, delete, or export as standalone HTML

---

## Tech stack

| Layer | Choice | Why |
|---|---|---|
| Framework | **Laravel 13** (PHP 8.3) | Predictable structure, fast Blade rendering, mature auth scaffolding (Breeze) |
| Frontend | **Blade + Tailwind CSS 3 + Alpine.js** | No SPA overhead — server-rendered pages, sprinkle Alpine for modals/toggles |
| AI provider | **Google Gemini 2.5 Flash** (primary) + Anthropic Claude (alternative) | Free-tier friendly, structured JSON mode (`responseMimeType: application/json`) |
| Database | **Postgres 15** (Cloud SQL on prod, SQLite locally) | Cloud Run filesystem is ephemeral, so the persistent DB lives in Cloud SQL |
| Container | **PHP 8.3 + Apache** (multi-stage Dockerfile) | Apache mod_rewrite handles Laravel's `public/` rewrites cleanly |
| Hosting | **Google Cloud Run** | Scale-to-zero, automatic HTTPS, simple Cloud SQL integration via Unix socket |
| Secrets | **Google Secret Manager** | `APP_KEY`, `DB_PASSWORD`, `GEMINI_API_KEY` injected at runtime, never baked in image |
| CI/CD | **Cloud Build** triggered by push to `main` | `cloudbuild.yaml` builds Docker image, pushes to Artifact Registry, deploys revision |

## Approach & logic

### Structured AI output
The hardest part of "AI-generates-a-landing-page" is making the output **predictable**. We solve it by:

- A strict **system prompt** that defines a JSON schema with required keys (`headline`, `sub_headline`, `description`, `benefits[]`, `features_breakdown[]`, `social_proof[]`, `pricing_display`, `cta`)
- Gemini's `responseMimeType: application/json` to force valid JSON
- A response **validator** that throws if any required key is missing — caller catches and falls back

### Resilience: retry + fallback chain
Gemini occasionally returns 503 (overloaded) or 429 (rate limit). The service automatically:
1. Retries the same model up to 2x with 750ms backoff for transient errors
2. Cascades to alternate models in order: `gemini-2.5-flash` → `gemini-2.5-flash-lite` → `gemini-2.0-flash` → `gemini-2.0-flash-lite`
3. If all four fail, returns a deterministic template-based draft so the page still renders — flagged via a notice banner

This means **the user always gets a usable page** even when Google's API is degraded.

### Three templates with distinct identity
Rather than swapping accent colors on the same layout (which felt like the same page in different paint), each template is its own Blade partial with **its own typography, layout, and visual language**:

- **Modern** — `landing-modern.blade.php`: cinematic dark, coral accent, 3D orb hero, glass cards, drift-up animations, particle field
- **Classic** — `landing-classic.blade.php`: editorial cream, serif (Cormorant Garamond), magazine-style with masthead, drop caps, Roman numerals
- **Bold** — `landing-bold.blade.php`: playful pastel, Memphis-style stickers, chunky 3px borders, color hard-shadows, scribble underlines

### Cinematic admin
The authenticated app shell mirrors the brand identity: bone-white background (`stone-50`), zinc-950 headings, coral primary CTAs with glow shadows, sticky compact page headers (52px), avatar gradient with online dot, three-color thumbnail gradient on cards matching each saved page's template, premium delete confirmation modal driven by Alpine (replacing `confirm()` browser dialog).

### Database schema
A single `sales_pages` table:
- `user_id` (FK), `product_name`, `description`, `features` (JSON), `target_audience`, `price`, `unique_selling_points`
- `tone`, `template`, `status`, `error`
- `generated_content` (JSON — the full structured AI output)
- timestamps + index on `(user_id, created_at)`

Authorization: every action checks `user_id === request->user()->id` — no global admin, every page is scoped to its owner.

## Project structure

```
app/
  Http/Controllers/
    DashboardController.php       — workspace dashboard with stats
    SalesPageController.php       — resource controller + export-html action
  Models/
    SalesPage.php                 — belongsTo User, JSON casts
  Services/
    SalesPageGenerator.php        — Gemini/Anthropic client with retry+fallback chain
database/
  migrations/2026_04_28_000001_create_sales_pages_table.php
resources/
  views/
    welcome.blade.php             — public landing
    dashboard.blade.php           — authenticated dashboard
    sales_pages/
      index.blade.php             — list / search / delete-modal
      create.blade.php            — input form (also used for edit)
      show.blade.php              — preview wrapper with browser chrome
      partials/
        landing.blade.php         — template router
        landing-modern.blade.php  — cinematic dark
        landing-classic.blade.php — editorial light
        landing-bold.blade.php    — playful sticker
      exports/standalone.blade.php — exported HTML
    auth/                         — login, register, etc.
    profile/edit.blade.php
    layouts/
      app.blade.php               — authenticated shell
      guest.blade.php             — split-screen auth shell (cinematic dark + light form)
      navigation.blade.php        — sticky top nav with brand mark + avatar
routes/web.php                    — /sales-pages resource + /export
tests/Feature/SalesPageFlowTest.php — 5 feature tests
```

## Tests

```
php artisan test
# 30 tests, 90 assertions, all passing
```

Coverage:
- Auth flow (Breeze defaults, 25 tests)
- SalesPageFlowTest (5 tests):
  - Guest redirected from protected routes
  - Authenticated user can view create form
  - User can generate and preview a sales page (hits the actual generator with fallback)
  - User can list, search, and delete pages
  - User cannot access another user's page (403)

## Deployment

```bash
# One-shot deploy to Cloud Run + Cloud SQL Postgres + Secret Manager
export PROJECT_ID=task-5d4f0
export REGION=asia-southeast2
export GEMINI_API_KEY=...
export APP_KEY=$(php artisan key:generate --show)
./deploy.sh
```

Continuous deployment is wired through `cloudbuild.yaml`: every push to `main` triggers Cloud Build → Docker build → Artifact Registry push → Cloud Run rollout.

## What I'd add next if I had more time

- **Section-by-section regenerate** — regenerate only the headline, only the CTA, etc. (currently full-page only)
- **Custom domain** with Cloud Load Balancer + IAP for stakeholder previews
- **Page analytics** — track preview views and export downloads
- **Rate limiting** on the generate endpoint per user
