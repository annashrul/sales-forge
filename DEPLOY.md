# Deploying to Google Cloud Run + Cloud SQL

This guide deploys the AI Sales Page Generator as a **Cloud Run** container,
backed by a **Cloud SQL Postgres** instance, with secrets in **Secret Manager**.
Estimated cost for a demo: **$0–5/month** (free tier covers most of it).

## 0. One-time prerequisites

```bash
# Install gcloud CLI: https://cloud.google.com/sdk/docs/install
gcloud auth login
gcloud auth application-default login
gcloud projects create my-ai-sales-page --set-as-default   # or use an existing project
gcloud beta billing projects link my-ai-sales-page --billing-account=XXXXXX-XXXXXX-XXXXXX
```

## 1. Generate an APP_KEY

Cloud Run env vars need a Laravel `APP_KEY`:

```bash
php artisan key:generate --show
# → base64:abc...   copy this value
```

## 2. Set environment variables for the deploy script

```bash
export PROJECT_ID="my-ai-sales-page"
export REGION="asia-southeast2"           # Jakarta — change to e.g. us-central1 if you prefer
export GEMINI_API_KEY="AIza..."
export APP_KEY="base64:abc..."            # from step 1
# Optional overrides:
# export DB_TIER="db-f1-micro"            # cheapest tier
# export SERVICE="ai-sales-page"
```

## 3. Run the deploy script

```bash
chmod +x deploy.sh
./deploy.sh
```

What it does (idempotent — safe to re-run):

1. Enables Cloud Run, Cloud SQL Admin, Cloud Build, Secret Manager, Artifact Registry APIs
2. Creates Cloud SQL Postgres 15 instance (`ai-sales-page-db`, tier `db-f1-micro`, 10 GB SSD)
3. Creates the `app` database and `app` user (random password)
4. Uploads `APP_KEY`, DB password, and `GEMINI_API_KEY` to Secret Manager
5. Submits a Cloud Build job from the local source — builds the Dockerfile, runs `composer install --no-dev` and `npm run build` inside the image
6. Deploys to Cloud Run with the Cloud SQL Unix socket attached at `/cloudsql/PROJECT:REGION:INSTANCE`
7. Patches `APP_URL` to the real Cloud Run URL once known

The script prints the live URL at the end. Open it in a browser, register an
account, and generate a sales page.

## 4. Verify

```bash
gcloud run services describe ai-sales-page --region "$REGION" --format='value(status.url)'
gcloud run services logs read ai-sales-page --region "$REGION" --limit=50
```

The container's entrypoint runs `php artisan migrate --force` on every start,
so the schema is created automatically on first deploy.

## 5. Updates

To deploy a new version after code changes:

```bash
./deploy.sh   # same script, just re-run; Cloud Build rebuilds and Cloud Run rolls out
```

Or manually:

```bash
gcloud run deploy ai-sales-page --source . --region "$REGION"
```

## 6. Tear down (avoid charges)

```bash
gcloud run services delete ai-sales-page --region "$REGION"
gcloud sql instances delete ai-sales-page-db
gcloud secrets delete ai-sales-page-app-key
gcloud secrets delete ai-sales-page-db-pass
gcloud secrets delete ai-sales-page-gemini-key
```

## Notes & gotchas

- **Cloud SQL connection** is via Unix socket `/cloudsql/PROJECT:REGION:INSTANCE`.
  The deploy script wires this with `--add-cloudsql-instances` and sets
  `DB_HOST=/cloudsql/...` — Laravel's pgsql driver picks it up via
  `host` and `port` parameters even when host is a socket path.
- **No persistent disk on Cloud Run.** All session/cache state is stored in
  Postgres (`SESSION_DRIVER=database`, `CACHE_STORE=database` are set as env vars).
- **First request cold start** can take ~5–10 seconds (PHP boot + Cloud SQL connect).
  Subsequent requests reuse the warm container.
- **Region**: Cloud Run + Cloud SQL must be in the same region (or pay egress).
- **HTTPS** is automatic via the `*.run.app` URL.
- **Custom domain**: `gcloud beta run domain-mappings create --service=ai-sales-page --domain=yourdomain.com --region="$REGION"`
- **Cost estimate**: db-f1-micro Postgres ≈ $7/mo, Cloud Run scales to zero when
  idle and the free tier covers ~2M requests/month. Total demo cost <$10/mo.
  To shave the SQL cost, use a Cloud SQL `db-f1-micro` only when needed and
  delete it between sessions, or fall back to the free tier (Spanner/Firestore
  alternatives require code changes).

## Troubleshooting

| Symptom | Fix |
|---|---|
| `cURL error 60: SSL certificate problem` in logs | Already handled — the image uses the system CA bundle (Debian's `ca-certificates`). |
| `SQLSTATE[08006] could not connect to server` | Cloud SQL takes ~30 s to start on first deploy; redeploy or check `--add-cloudsql-instances` is set. |
| Migration errors on first boot | Open a Cloud Run shell: `gcloud run services proxy ai-sales-page --region="$REGION"` and run `php artisan migrate` manually inside the container, or check `gcloud run services logs read`. |
| `App key not set` | Make sure `APP_KEY` was a non-empty `base64:...` value when you ran the script. |
