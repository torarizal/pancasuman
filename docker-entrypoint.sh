#!/bin/bash
set -e

# Substitusi variabel $PORT ke dalam konfigurasi Nginx
envsubst '$PORT' < /etc/nginx/sites-available/default > /etc/nginx/sites-enabled/default

# Jalankan optimasi & migrasi database
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force

# Jalankan PHP-FPM dan Nginx
php-fpm -D
nginx -g "daemon off;"