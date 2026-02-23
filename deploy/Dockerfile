# Stage 1: Composer Bağımlılıklarını Yükle
FROM composer:2.8 as composer_deps

WORKDIR /app

# intl eklentisi için gerekli olan ICU kütüphanelerini kur ve ardından eklentiyi yükle
RUN apk add --no-cache \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    icu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd intl

COPY composer.json composer.lock ./
# Sadece production bağımlılıklarını yükle ve autoloader'ı optimize et
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts --ignore-platform-req=php


# Stage 2: Frontend Varlıklarını Derle
FROM node:20-bullseye-slim AS node_builder

WORKDIR /app

COPY package*.json ./
RUN npm install

# Tüm proje dosyalarını kopyala
COPY . .

# Composer aşamasından vendor klasörünü kopyala
# Bu, npm run build'in Filament CSS dosyalarını bulmasını sağlar
COPY --from=composer_deps /app/vendor ./vendor/

# Frontend varlıklarını derle
RUN npm run build


# Stage 3: PHP Production Imajı
FROM dunglas/frankenphp:php8.4-alpine

WORKDIR /app

# Sistem paketleri (git, supervisor)
RUN apk add --no-cache \
    git \
    supervisor

# PHP eklentileri
RUN install-php-extensions \
    pdo_mysql \
    gd \
    intl \
    zip \
    opcache \
    redis \
    pcntl \
    bcmath

# Özel PHP ayarlarını kopyala
COPY deploy/php.ini /usr/local/etc/php/conf.d/zz-custom.ini

# Proje dosyalarını kopyala (vendor ve build hariç)
COPY . .

# Derlenmiş frontend varlıklarını node_builder'dan kopyala
COPY --from=node_builder /app/public/build /app/public/build

# Yüklenmiş Composer bağımlılıklarını kopyala
COPY --from=composer_deps /app/vendor ./vendor

# İzinler
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache && \
    chmod -R 775 /app/storage /app/bootstrap/cache

# Supervisor config
COPY deploy/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Entrypoint
COPY deploy/prod.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
