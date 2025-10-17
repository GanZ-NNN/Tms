FROM php:8.2-fpm

# ใช้ ENV แทน ARG
ENV WWWUSER 1000
ENV WWWGROUP 1000

WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    git curl unzip libzip-dev libpng-dev libjpeg-dev libfreetype6-dev \
    supervisor libpq-dev;

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo pdo_pgsql zip;

RUN pecl install redis && docker-php-ext-enable redis;

# Get Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer;

# สร้าง User และ Group โดยใช้ ENV
RUN groupadd -g $WWWGROUP sail && \
    useradd -u $WWWUSER -ms /bin/bash -g sail sail;

# Switch to user
USER sail