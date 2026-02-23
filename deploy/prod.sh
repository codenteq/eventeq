#!/bin/sh
set -e

echo "Starting production setup..."

if [ ! -L public/storage ]; then
    echo "Creating storage link..."
    php artisan storage:link
fi

echo "Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan filament:optimize

echo "Running migrations..."
php artisan migrate --force --no-interaction

echo "Production setup completed!"

exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
