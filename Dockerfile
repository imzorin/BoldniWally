FROM php:8.3-cli

WORKDIR /app

COPY . .

RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev zip nodejs npm \
    && docker-php-ext-install zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev --optimize-autoloader

RUN npm install
RUN npm run build

# CREATE STORAGE DIRECTORIES
RUN mkdir -p storage/framework/cache/data
RUN mkdir -p storage/framework/sessions
RUN mkdir -p storage/framework/views
RUN mkdir -p storage/logs
RUN mkdir -p bootstrap/cache

# FIX PERMISSIONS
RUN chmod -R 775 storage bootstrap/cache

RUN php artisan key:generate --force || true
RUN php artisan optimize || true

EXPOSE 10000

CMD php -S 0.0.0.0:${PORT} -t public