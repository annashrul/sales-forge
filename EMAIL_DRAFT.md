# Email Draft for Submission

**To**: hrbedaieofficial@gmail.com
**Subject**: Task Submission — AI Sales Page Generator (Option B) — Anashrul Yusuf

---

Dear Hiring Team,

Please find my task submission for the AI System development assignment below.

**Option chosen**: B — AI Sales Page Generator

## Live URL
https://ai-sales-page-ixxfhjy2za-et.a.run.app

The application is publicly accessible, hosted on Google Cloud Run with a Cloud SQL Postgres database in the Jakarta region. You can register a new account, generate a sales page in under 30 seconds, and preview it in three different design templates.

## Source code
https://github.com/annashrul/sales-forge

## Video walkthrough
https://youtu.be/VorzXSMBGiQ

A ~7-minute screen recording covering the technical approach and a full end-to-end walkthrough — registering, generating a sales page, previewing across templates, regenerating, exporting HTML, and deletion.

## Brief approach

Built with Laravel 13 + Blade + Tailwind + Alpine.js, with Google Gemini 2.5 Flash as the primary LLM (Anthropic Claude as alternative). The generator service includes automatic retry with a model fallback chain (`gemini-2.5-flash` → `flash-lite` → `2.0-flash` → `2.0-flash-lite`) so the page stays usable even when the API is degraded; if every model fails, a deterministic template-based draft fills in so the user is never blocked.

The AI output is enforced as structured JSON via a strict system prompt and Gemini's `responseMimeType: application/json`, then validated for required keys before saving. Each generated page carries `headline`, `sub_headline`, `description`, `benefits`, `features_breakdown`, `social_proof`, `pricing_display`, and `cta` — all rendered as a real, styled landing page (not raw text).

Three design templates are not just color swaps — each is its own Blade partial with distinct typography and layout: **Modern** (cinematic dark with a 3D coral orb), **Classic** (editorial cream with serif and drop caps), **Bold** (playful pastel sticker style with chunky borders).

Deployment is fully containerized: a Dockerfile (PHP 8.3 + Apache), Cloud Run for compute, Cloud SQL for the database, Secret Manager for API keys, and Cloud Build for CI on every push to `main`.

## Bonus features delivered

- ✅ Three distinct design templates — fully different visual identities
- ✅ Standalone HTML export (one click, ready-to-host)
- ✅ Automatic AI fallback chain for reliability
- ✅ Live preview wrapped in browser-chrome for stakeholder reviews
- ✅ Search across saved pages
- ✅ Premium Alpine-driven delete confirmation modal

## Tests

30 feature tests passing — covers auth, generation flow (real API call with fallback), search, delete, and authorization.

A more detailed write-up is in `SUBMISSION.md` in the repo root.

Thank you for the opportunity. Happy to walk through any part of the system live if helpful.

Best regards,
**Anashrul Yusuf**
anashrulyusuf@gmail.com
