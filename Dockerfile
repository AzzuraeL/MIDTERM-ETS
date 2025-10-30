FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    ca-certificates \
    libpq-dev \
    libmariadb-dev \
    zlib1g-dev \
    libzip-dev \
    unzip \
    npm \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    pdo_pgsql \
    zip \
    && docker-php-ext-enable pdo pdo_mysql pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN chmod +x start.sh

RUN composer install --no-interaction --prefer-dist --optimize-autoloader
RUN npm install
RUN npm run build

RUN mkdir -p storage/framework/{sessions,views,cache,testing} storage/logs bootstrap/cache \
    && chmod -R 777 storage bootstrap/cache

CMD ["bash", "start.sh"]
