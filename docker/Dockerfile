FROM php:8.4-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl unzip zip \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libonig-dev libxml2-dev \
    libpq-dev autoconf build-essential pkg-config libssl-dev \
    nodejs npm \
 && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install pdo_pgsql pgsql mbstring exif pcntl bcmath gd

# Redis extension (works with PHP 8.4)
RUN pecl install redis-6.3.0RC1 \
 && docker-php-ext-enable redis

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www