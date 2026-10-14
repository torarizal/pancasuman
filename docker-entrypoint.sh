#!/bin/bash
set -e

# Mengganti port default Nginx (80) dengan port dinamis dari Railway ($PORT)
# Jika variabel PORT kosong, otomatis fallback ke port 8080
PORT_TO_USE="${PORT:-8080}"
sed -i "s/listen 80;/listen ${PORT_TO_USE};/g" /etc/nginx/sites-available/default

echo "Nginx dikonfigurasi menggunakan port: $PORT_TO_USE"

# Optimasi Laravel & Migrasi Database otomatis
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force

# Jalankan PHP-FPM di background dan Nginx di foreground
php-fpm -D
nginx -g "daemon off;"