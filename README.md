# AI Sales Page Generator

A Laravel 13 web application that turns raw product information into a complete,
styled, persuasive sales page powered by Anthropic Claude.

Built for the **AI Sales Page Generator** option of the technical task.

## Features

- **User authentication** (register / login / logout / password reset / profile)
  via Laravel Breeze.
- **Structured product input form** — name, description, key features,
  target audience, price, unique selling points, tone, design template.
- **AI generation** — sends product data to the Anthropic Messages API
  (`claude-haiku-4-5`) and returns a structured JSON sales-page object
  (headline, sub-headline, description, benefits, features breakdown,
  social proof, pricing display, call-to-action).
- **Live preview** — generated content is rendered as a real, multi-section
  landing page (hero, benefits, features, social proof, pricing/CTA).
- **Three design templates** — Modern (gradient indigo/violet),
  Classic (slate/amber), Bold (rose/yellow).
- **Saved pages** — list with search, view, regenerate (edit), and delete.
- **HTML export** — download any generated page as a standalone HTML file
  (Tailwind via CDN, ready to host).
- **Graceful fallback** — when the API key is missing, fails, or runs out of
  credits, a deterministic template-based generator still produces a complete
  sales-page draft so the demo always works.

## Tech Stack

- Laravel 13 / PHP 8.3
- SQLite (zero-config; one file at `database/database.sqlite`)
- Blade templates + Tailwind CSS 3 + Alpine.js (no SPA framework)
- Anthropic Messages API (HTTP client, no SDK dependency)
- PHPUnit feature tests

## Setup

```bash
# 1. Install PHP dependencies
composer install

# 2. Copy and edit env
cp .env.example .env
php artisan key:generate

# 3. Add your Anthropic API key (optional — fallback works without it)
# Edit .env and set:
#   ANTHROPIC_API_KEY=sk-ant-...
#   ANTHROPIC_MODEL=claude-haiku-4-5-20251001

# 4. Create the SQLite database and run migrations
touch database/database.sqlite
php artisan migrate

# 5. Build frontend assets
npm install
npm run build

# 6. Start the dev server
php artisan serve
# → visit http://127.0.0.1:8000
```

### Windows SSL note

The first call from a Windows PHP install often fails with
`cURL error 60: SSL certificate problem`. The repo ships a CA bundle at
`storage/certs/cacert.pem` and the generator passes it explicitly to Guzzle,
so requests succeed without touching `php.ini`.

## How It Works

1. **`SalesPageController@store`** validates the form, creates a
   `SalesPage` row with `status=generating`, and calls
   `SalesPageGenerator::generate()`.
2. **`App\Services\SalesPageGenerator`** builds a structured prompt that
   instructs Claude to respond as a single JSON object with a fixed schema
   (headline, benefits, features_breakdown, social_proof, pricing_display, cta).
   The system prompt forbids markdown / commentary — only JSON.
3. The response is parsed, validated, and stored on the row as
   `generated_content` (JSON-cast Eloquent attribute).
4. **`sales_pages.show`** renders `partials/landing.blade.php`, which lays
   out the JSON as a real landing page using template-aware Tailwind classes.
5. **Export** re-renders the same partial inside a standalone HTML document
   (`exports/standalone.blade.php`) with Tailwind via CDN and serves it as
   a downloadable file.

If the API call fails for any reason (no key, network error, billing
problem), the generator catches the exception and returns a deterministic
template-based draft. The page row is saved with `status=ready` plus an
`error` notice so the user sees what happened but still has a usable page.

## Project Layout

```
app/
  Http/Controllers/
    DashboardController.php       # dashboard with user stats
    SalesPageController.php       # resource controller + export
  Models/
    SalesPage.php                 # belongsTo User; JSON casts
  Services/
    SalesPageGenerator.php        # Anthropic client + fallback
database/
  migrations/
    2026_04_28_000001_create_sales_pages_table.php
resources/
  views/
    sales_pages/
      index.blade.php             # list + search + delete
      create.blade.php            # input form (also used for edit)
      show.blade.php              # preview wrapper
      partials/landing.blade.php  # the rendered landing page
      exports/standalone.blade.php # standalone HTML export
    dashboard.blade.php           # stats + recent pages
    welcome.blade.php             # public landing
routes/
  web.php                         # /sales-pages resource + /export
storage/certs/cacert.pem          # Mozilla CA bundle for Windows SSL
tests/Feature/SalesPageFlowTest.php
```

## Testing

```bash
php artisan test --filter=SalesPageFlowTest
```

Covers:
- guest redirects on protected routes
- create-form rendering
- end-to-end generate + preview
- list / search / delete
- ownership authorization (403 for other users' pages)

All 5 tests pass against the fallback generator (so tests never make a
network call).

## Deploying to Google Cloud

A complete one-shot deploy to **Google Cloud Run + Cloud SQL Postgres + Secret
Manager** ships in this repo. See [`DEPLOY.md`](DEPLOY.md) for the full guide.

```bash
export PROJECT_ID=my-ai-sales-page
export REGION=asia-southeast2
export GEMINI_API_KEY=AIza...
export APP_KEY=$(php artisan key:generate --show)
./deploy.sh
```

The script enables APIs, provisions Cloud SQL, uploads secrets, runs Cloud
Build with the included `Dockerfile`, and rolls out a public Cloud Run service
with HTTPS. Estimated demo cost: $0–10/month.

## Submission Notes

- Live working URL: deploy via `./deploy.sh` (Cloud Run) or copy the same
  Dockerfile to Railway / Render / Fly.io. SQLite is the dev default; the
  Docker image runs on Postgres in production.
- Database: SQLite, persisted in `database/database.sqlite`, writable by
  the web user.
- Optional bonuses implemented:
  - Standalone HTML export
  - Three design templates (Modern / Classic / Bold)
  - Tone selector (Persuasive / Formal / Casual / Urgent / Inspirational)
  - Search across saved pages
  - Regenerate-existing-page flow (edit + re-call AI)
