FROM php:8.2-fpm

# Install dependencies sistem & ekstensi PHP yang dibutuhkan Laravel
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nginx \
    libzip-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install ekstensi PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Salin seluruh file project
COPY . .

# Install dependencies composer (tanpa dev package agar ringan)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Berikan izin akses folder storage dan bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Konfigurasi Nginx untuk mengarahkan ke folder public Laravel
RUN echo 'server {\n\
    listen 80;\n\
    index index.php index.html;\n\
    root /var/www/html/public;\n\
    location / {\n\
        try_files $uri $uri/ /index.php?$query_string;\n\
    }\n\
    location ~ \.php$ {\n\
        fastcgi_pass 127.0.0.1:9000;\n\
        fastcgi_index index.php;\n\
        include fastcgi_params;\n\
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;\n\
    }\n\
}' > /etc/nginx/sites-available/default

# Expose port 80 (Railway akan otomatis mendeteksi port ini atau environment $PORT)
EXPOSE 80

# Jalankan script startup untuk migrasi database dan menjalankan Nginx + PHP-FPM
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh
ENTRYPOINT ["docker-entrypoint.sh"]