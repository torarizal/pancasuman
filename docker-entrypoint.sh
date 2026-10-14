#!/bin/bash
set -e

# Jalankan optimasi cache dan migrasi database otomatis setiap deploy
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force

# Jalankan PHP-FPM di background
php-fpm -D

# Jalankan Nginx di foreground agar container tetap menyala
nginx -g "daemon off;"