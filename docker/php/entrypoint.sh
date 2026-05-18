#!/bin/bash
set -e

echo "⏳ Waiting for PostgreSQL..."
while ! nc -z $DB_HOST $DB_PORT; do
  sleep 1
done
echo "✓ PostgreSQL is ready"

echo "⏳ Running migrations..."
php artisan migrate --force || true

echo "⏳ Clearing cache..."
php artisan cache:clear || true
php artisan config:clear || true

echo "⏳ Publishing assets..."
php artisan storage:link || true

echo "✓ Laravel setup complete!"

exec php-fpm
