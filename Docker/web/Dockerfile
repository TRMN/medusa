FROM php:7.4-fpm
LABEL maintainer="Douglas Needham"

RUN apt-get update \
    && apt-get install -y imagemagick ruby-erubis libpng-dev libzip-dev nodejs npm zlib1g-dev \
    && curl -sLS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && docker-php-ext-install gd \
    && docker-php-ext-install zip \
    && pecl install mongodb && docker-php-ext-enable mongodb

WORKDIR /var/www/html

ADD . /var/www/html

CMD /var/www/html/Docker/web/start.sh

