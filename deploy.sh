#!/usr/bin/env bash
#
# One-shot deploy script for AI Sales Page Generator → Google Cloud Run + Cloud SQL.
#
# Prerequisites:
#   - gcloud CLI installed and authenticated:   gcloud auth login
#   - A billing-enabled GCP project ID
#   - Optional: doppler/secret-manager keys; this script just reads from env.
#
# Usage:
#   PROJECT_ID=my-project REGION=asia-southeast2 ./deploy.sh
#
# Idempotent: re-runs are safe; existing resources are reused.

set -euo pipefail

PROJECT_ID="${PROJECT_ID:?Set PROJECT_ID env var}"
REGION="${REGION:-asia-southeast2}"
SERVICE="${SERVICE:-ai-sales-page}"
DB_INSTANCE="${DB_INSTANCE:-${SERVICE}-db}"
DB_NAME="${DB_NAME:-app}"
DB_USER="${DB_USER:-app}"
DB_TIER="${DB_TIER:-db-f1-micro}"

# Required runtime secrets (set them in your shell before running):
#   GEMINI_API_KEY, APP_KEY (run `php artisan key:generate --show`)
GEMINI_API_KEY="${GEMINI_API_KEY:?Set GEMINI_API_KEY env var}"
APP_KEY="${APP_KEY:?Set APP_KEY env var (run: php artisan key:generate --show)}"
DB_PASSWORD="${DB_PASSWORD:-$(openssl rand -base64 24 | tr -d '/+=')}"

echo "==> Project: $PROJECT_ID  Region: $REGION  Service: $SERVICE"
gcloud config set project "$PROJECT_ID" >/dev/null

echo "==> Enabling required APIs"
gcloud services enable \
  run.googleapis.com \
  sqladmin.googleapis.com \
  cloudbuild.googleapis.com \
  secretmanager.googleapis.com \
  artifactregistry.googleapis.com

# ---- Cloud SQL (Postgres) ---------------------------------------------------
if ! gcloud sql instances describe "$DB_INSTANCE" --quiet >/dev/null 2>&1; then
  echo "==> Creating Cloud SQL instance ($DB_INSTANCE, $DB_TIER)..."
  gcloud sql instances create "$DB_INSTANCE" \
    --database-version=POSTGRES_15 \
    --tier="$DB_TIER" \
    --region="$REGION" \
    --storage-type=SSD \
    --storage-size=10GB \
    --no-backup
else
  echo "==> Cloud SQL instance $DB_INSTANCE already exists. Skipping."
fi

if ! gcloud sql databases describe "$DB_NAME" --instance="$DB_INSTANCE" --quiet >/dev/null 2>&1; then
  gcloud sql databases create "$DB_NAME" --instance="$DB_INSTANCE"
fi

if ! gcloud sql users list --instance="$DB_INSTANCE" --format="value(name)" | grep -q "^${DB_USER}$"; then
  gcloud sql users create "$DB_USER" --instance="$DB_INSTANCE" --password="$DB_PASSWORD"
else
  gcloud sql users set-password "$DB_USER" --instance="$DB_INSTANCE" --password="$DB_PASSWORD"
fi

CONN_NAME="$(gcloud sql instances describe "$DB_INSTANCE" --format='value(connectionName)')"
echo "==> Cloud SQL connection name: $CONN_NAME"

# ---- Secret Manager ---------------------------------------------------------
upsert_secret () {
  local name="$1" value="$2"
  if ! gcloud secrets describe "$name" --quiet >/dev/null 2>&1; then
    printf "%s" "$value" | gcloud secrets create "$name" --replication-policy="automatic" --data-file=-
  else
    printf "%s" "$value" | gcloud secrets versions add "$name" --data-file=-
  fi
}

echo "==> Upserting secrets"
upsert_secret "${SERVICE}-app-key"    "$APP_KEY"
upsert_secret "${SERVICE}-db-pass"    "$DB_PASSWORD"
upsert_secret "${SERVICE}-gemini-key" "$GEMINI_API_KEY"

echo "==> Granting Secret Manager access to Cloud Run runtime service account"
PROJECT_NUMBER="$(gcloud projects describe "$PROJECT_ID" --format='value(projectNumber)')"
RUNTIME_SA="${PROJECT_NUMBER}-compute@developer.gserviceaccount.com"
for SECRET_NAME in "${SERVICE}-app-key" "${SERVICE}-db-pass" "${SERVICE}-gemini-key"; do
  gcloud secrets add-iam-policy-binding "$SECRET_NAME" \
    --member="serviceAccount:${RUNTIME_SA}" \
    --role="roles/secretmanager.secretAccessor" \
    --quiet >/dev/null
done

# ---- Build & deploy ---------------------------------------------------------
echo "==> Building & deploying with Cloud Build → Cloud Run"
gcloud run deploy "$SERVICE" \
  --source . \
  --region "$REGION" \
  --platform managed \
  --allow-unauthenticated \
  --add-cloudsql-instances "$CONN_NAME" \
  --memory 1Gi \
  --cpu 1 \
  --timeout 300 \
  --max-instances 3 \
  --set-env-vars "APP_ENV=production,APP_DEBUG=false,APP_URL=https://${SERVICE}-PLACEHOLDER.run.app,LOG_CHANNEL=stderr,DB_CONNECTION=pgsql,DB_HOST=/cloudsql/${CONN_NAME},DB_PORT=5432,DB_DATABASE=${DB_NAME},DB_USERNAME=${DB_USER},SESSION_DRIVER=database,CACHE_STORE=database,QUEUE_CONNECTION=sync,AI_PROVIDER=gemini,GEMINI_MODEL=gemini-2.5-flash" \
  --set-secrets "APP_KEY=${SERVICE}-app-key:latest,DB_PASSWORD=${SERVICE}-db-pass:latest,GEMINI_API_KEY=${SERVICE}-gemini-key:latest"

# Patch APP_URL to the real URL once we know it.
URL="$(gcloud run services describe "$SERVICE" --region "$REGION" --format='value(status.url)')"
echo "==> Service URL: $URL"
gcloud run services update "$SERVICE" \
  --region "$REGION" \
  --update-env-vars "APP_URL=${URL}"

echo
echo "================================================================"
echo "  Deploy complete."
echo "  URL:        $URL"
echo "  DB instance:$DB_INSTANCE  ($CONN_NAME)"
echo "  Region:     $REGION"
echo "  DB pass:    stored in Secret Manager (${SERVICE}-db-pass)"
echo "================================================================"
