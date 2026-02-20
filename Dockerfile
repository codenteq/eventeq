# Stage 1 — Frontend Build
FROM node:20-alpine AS frontend

WORKDIR /app

COPY package.json package-lock.json* yarn.lock* ./

RUN if [ -f yarn.lock ]; then \
        yarn install --frozen-lockfile; \
    elif [ -f package-lock.json ]; then \
        npm ci; \
    else \
        npm install; \
    fi

COPY resources/ resources/
COPY vite.config.js ./
COPY postcss.config.js* ./
COPY tailwind.config.js* ./

RUN npm run build

# Stage 2 — Composer Dependencies
FROM composer:2 AS composer

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --no-scripts --no-autoloader --prefer-dist --ignore-platform-req=php

COPY . .
RUN composer dump-autoload --optimize --no-dev --ignore-platform-req=php

# Stage 3 — RoadRunner Binary
FROM ghcr.io/roadrunner-server/roadrunner:2024 AS roadrunner

# Stage 4 — Production Image
FROM php:8.3-cli-alpine AS production

LABEL maintainer="codenteq" \
      org.opencontainers.image.source="https://github.com/codenteq/eventeq" \
      org.opencontainers.image.description="Eventeq production image"

RUN apk add --no-cache \
        wget \
        freetype-dev \
        libjpeg-turbo-dev \
        libpng-dev \
        libzip-dev \
        icu-dev \
        libxml2-dev \
        oniguruma-dev \
        imagemagick-dev \
        imagemagick \
        libgomp \
        postgresql-dev \
        $PHPIZE_DEPS \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        pdo_pgsql \
        pgsql \
        gd \
        zip \
        bcmath \
        intl \
        xml \
        mbstring \
        soap \
        pcntl \
        sockets \
        opcache \
    && pecl install redis imagick \
    && docker-php-ext-enable redis imagick \
    && apk del $PHPIZE_DEPS \
    && rm -rf /var/cache/apk/* /tmp/pear

RUN cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

RUN { \
        echo "memory_limit=256M"; \
        echo "upload_max_filesize=64M"; \
        echo "post_max_size=64M"; \
        echo "max_execution_time=120"; \
        echo "opcache.enable=1"; \
        echo "opcache.validate_timestamps=0"; \
    } > "$PHP_INI_DIR/conf.d/app.ini"

WORKDIR /var/www/html

COPY --from=roadrunner /usr/bin/rr /usr/local/bin/rr
COPY --from=composer /app/vendor ./vendor
COPY --from=composer /app .
COPY --from=frontend /app/public/build ./public/build

RUN mkdir -p \
        storage/logs \
        storage/framework/sessions \
        storage/framework/views \
        storage/framework/cache/data \
        bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

COPY .rr.yaml .

EXPOSE 8080

HEALTHCHECK --interval=30s --timeout=5s --start-period=10s --retries=3 \
    CMD wget -qO- http://localhost:8080/up || exit 1

USER www-data

CMD ["sh", "-c", "php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan migrate --force && rr serve -c /var/www/html/.rr.yaml"]
