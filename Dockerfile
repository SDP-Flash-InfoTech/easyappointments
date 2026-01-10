# syntax=docker/dockerfile:1

FROM node:18-bookworm AS assets
WORKDIR /app
COPY package.json package-lock.json* ./
RUN if [ -f package-lock.json ]; then npm ci; else npm install; fi
COPY gulpfile.js babel.config.json ./
COPY assets ./assets
RUN npx gulp compile

FROM php:8.2-fpm-bookworm

ENV APP_ENV=production \
    COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_NO_INTERACTION=1

WORKDIR /var/www/html

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        nginx \
        supervisor \
        git \
        zip \
        unzip \
        curl \
        libldap2-dev \
        libicu-dev \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libzip-dev \
        libonig-dev \
        libxml2-dev \
    && curl -sSL https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions -o /usr/local/bin/install-php-extensions \
    && chmod +x /usr/local/bin/install-php-extensions \
    && install-php-extensions \
        gd \
        intl \
        ldap \
        mbstring \
        mysqli \
        pdo_mysql \
        soap \
        sockets \
        xml \
        zip \
        exif \
        gettext \
        bcmath \
        opcache \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY . .

COPY docker/nginx/nginx.conf /etc/nginx/conf.d/default.conf
RUN sed -i "s/php-fpm:9000/127.0.0.1:9000/" /etc/nginx/conf.d/default.conf

COPY docker/php-fpm/php-ini-overrides.ini /usr/local/etc/php/conf.d/99-overrides.ini
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY --from=assets /app/assets ./assets

RUN chown -R www-data:www-data storage application/cache application/logs || true \
    && find storage -type d -exec chmod 775 {} + \
    && find storage -type f -exec chmod 664 {} + \
    && mkdir -p /run/php

RUN composer install --no-dev --optimize-autoloader --prefer-dist

EXPOSE 80

HEALTHCHECK --interval=30s --timeout=5s --retries=3 CMD curl -f http://127.0.0.1/ || exit 1

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
