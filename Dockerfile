# syntax=docker/dockerfile:1

########################################
# Base — PHP 8.3 FPM + required extensions
########################################
FROM php:8.3-fpm-alpine AS base

RUN apk add --no-cache \
        icu-libs \
        libpq \
        libpng \
        libjpeg-turbo \
        libwebp \
        freetype \
        libzip \
    && apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
        icu-dev \
        libpq-dev \
        libpng-dev \
        libjpeg-turbo-dev \
        libwebp-dev \
        freetype-dev \
        libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j"$(nproc)" pdo_pgsql intl opcache gd zip \
    && apk del .build-deps

# Full ICU locale data (Alpine ships English-only by default; the site is Arabic-first).
# Separate layer so it never invalidates the extension-compile cache above.
RUN apk add --no-cache icu-data-full

COPY docker/php/php.ini /usr/local/etc/php/conf.d/zz-app.ini

WORKDIR /var/www/html

########################################
# Dev — bind-mounted source + Composer CLI
########################################
FROM base AS dev

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

# Windows bind mounts surface as root:root 755, which www-data cannot write to.
# Run the FPM pool as root in dev only — prod copies files with www-data ownership instead.
RUN sed -i 's/^user = www-data/user = root/; s/^group = www-data/group = root/' /usr/local/etc/php-fpm.d/www.conf

# Disable OPcache in dev: Windows bind-mount mtimes are not reliably seen inside the
# container, so OPcache serves stale bytecode after edits. Prod keeps OPcache (opcache-prod.ini).
RUN printf "opcache.enable=0\nopcache.enable_cli=0\n" > /usr/local/etc/php/conf.d/zz-dev.ini

CMD ["php-fpm", "-R"]

########################################
# Assets — build front-end for production
########################################
FROM node:22-alpine AS assets

WORKDIR /var/www/html
COPY package.json package-lock.json* ./
RUN npm ci
COPY vite.config.js ./
COPY resources ./resources
COPY public ./public
RUN npm run build

########################################
# Vendor — production PHP dependencies
########################################
FROM composer:2 AS vendor

WORKDIR /var/www/html
COPY composer.json composer.lock ./
RUN composer install \
        --no-dev \
        --no-scripts \
        --no-interaction \
        --prefer-dist \
        --optimize-autoloader

########################################
# Prod — production-ready final stage
########################################
FROM base AS prod

ENV APP_ENV=production \
    APP_DEBUG=false

COPY docker/php/opcache-prod.ini /usr/local/etc/php/conf.d/zz-opcache.ini

COPY --chown=www-data:www-data . .
COPY --from=vendor --chown=www-data:www-data /var/www/html/vendor ./vendor
COPY --from=assets --chown=www-data:www-data /var/www/html/public/build ./public/build

RUN chown -R www-data:www-data storage bootstrap/cache

USER www-data

EXPOSE 9000
CMD ["php-fpm"]
