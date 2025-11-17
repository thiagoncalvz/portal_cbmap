FROM serversideup/php:8.4-fpm-nginx-alpine

ENV PHP_OPCACHE_ENABLE=1

USER root

RUN apk update && apk add --no-cache nodejs npm && \
    install-php-extensions intl gd

COPY --chown=www-data:www-data . /var/www/html

USER www-data

WORKDIR /var/www/html

RUN npm install && npm run build

RUN composer install --no-interaction --optimize-autoloader --no-dev

