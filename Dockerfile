FROM php:8.4-fpm-alpine

RUN apk add --no-cache postgresql-dev libpq

RUN docker-php-ext-install pdo pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

run addgroup -S appgroup && adduser -S appuser -G appgroup

WORKDIR /app

COPY --chown=appuser:appgroup . .

CMD ["php-fpm"]