FROM registry.gitlab.com/racoony-software/team-cashbox/team-cashbox-api/php:7.2-fpm-alpine
LABEL maintainer="rookian@gmail.com"

RUN apk add --no-cache $PHPIZE_DEPS \
    && pecl install xdebug-2.6.1 \
    && docker-php-ext-enable xdebug
