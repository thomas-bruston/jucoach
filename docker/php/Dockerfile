FROM php:8.3-fpm

ARG APP_ENV=development

# Dépendances système
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libssl-dev \
    pkg-config \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock* ./
RUN if [ "$APP_ENV" = "production" ]; then \
        composer install --no-scripts --no-autoloader --no-dev; \
    else \
        composer install --no-scripts --no-autoloader; \
    fi

COPY . .
RUN composer dump-autoload --optimize

RUN chown -R www-data:www-data /var/www/html/public