#!/usr/bin/env bash
set -e

# Cloud Run injects PORT (default 8080). Apache config already references it.
export PORT="${PORT:-8080}"

# Ensure storage dirs exist and are writable (rebuild on every container start
# because the image filesystem is read-only-ish under Cloud Run for /storage paths).
mkdir -p \
  storage/framework/cache/data \
  storage/framework/sessions \
  storage/framework/views \
  storage/logs \
  bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache || true

# Cache Laravel config / routes / views for speed.
php artisan config:cache  || true
php artisan route:cache   || true
php artisan view:cache    || true

# Run database migrations against Cloud SQL.
# DB_CONNECTION + DB_HOST etc are injected via Cloud Run env vars / Secret Manager.
if [ "${RUN_MIGRATIONS:-true}" = "true" ]; then
  php artisan migrate --force || echo "[entrypoint] migrate failed — continuing"
fi

exec "$@"
