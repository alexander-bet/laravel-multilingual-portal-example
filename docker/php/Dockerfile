# syntax=docker/dockerfile:1
# Базовый слой: PHP + расширения
FROM php:8.3-fpm-alpine AS base

# Устанавливаем системные зависимости (кэшируется BuildKit)
RUN --mount=type=cache,target=/var/cache/apk \
    apk add --no-cache \
    git curl wget \
    postgresql-client postgresql-dev \
    libzip-dev zip unzip \
    freetype-dev libjpeg-turbo-dev libpng-dev \
    icu-dev oniguruma-dev \
    autoconf make gcc g++ pkgconfig \
    imagemagick imagemagick-dev \
    libheif libheif-dev \
    libwebp libwebp-dev \
    libavif libavif-dev \
    php83-pecl-redis

RUN docker-php-ext-install pdo_pgsql zip intl mbstring bcmath opcache exif
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp && docker-php-ext-install gd

# Imagick — кэшируется через BuildKit, не пересобирается без изменений
RUN --mount=type=cache,target=/tmp/pear \
    pecl install imagick && docker-php-ext-enable imagick

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY docker/php/www.conf /usr/local/etc/php-fpm.d/www.conf

# -------------------------------
# Dev stage
# -------------------------------
FROM base AS dev
CMD ["php-fpm"]

# -------------------------------
# Prod stage
# -------------------------------
FROM base AS prod

# Копируем composer файлы + модули — кэшируется пока они не меняются
COPY backend/composer.json backend/composer.lock /app/
COPY backend/Modules /app/Modules

RUN --mount=type=cache,target=/root/.composer \
    composer install --no-dev --optimize-autoloader --no-progress --no-interaction --no-scripts

# Теперь копируем весь код
COPY backend /app

COPY docker/php/www.conf /usr/local/etc/php-fpm.d/www.conf

RUN chown -R www-data:www-data /app && \
    chmod -R 755 /app && \
    chmod -R 775 /app/storage && \
    chmod -R 775 /app/bootstrap/cache

CMD ["php-fpm"]
