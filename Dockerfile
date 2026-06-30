FROM php:8.3-cli

WORKDIR /app

COPY . .

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libzip-dev \
    libsqlite3-dev \
    zip \
    nodejs \
    npm \
    && docker-php-ext-install zip pdo_sqlite

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev --optimize-autoloader

RUN npm install
RUN npm run build

# Storage directories
RUN mkdir -p storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache \
    database

# SQLite database
RUN touch database/database.sqlite

# Permissions
RUN chmod -R 775 storage bootstrap/cache database

EXPOSE 10000

CMD php -S 0.0.0.0:${PORT} -t public