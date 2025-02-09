FROM php:7.4-fpm
LABEL maintainer="Douglas Needham"

ADD Docker/web/php.ini /usr/local/etc/php/php.ini

RUN apt-get update \
    && apt-get install -y gnupg imagemagick nodejs npm ruby-erubis  \
    && apt-get install -y libicu-dev libpng-dev libzip-dev zlib1g-dev \
    && curl -sLS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && docker-php-ext-install gd \
    && docker-php-ext-install intl \
    && docker-php-ext-install zip \
    && pecl install mongodb-1.19.4 && docker-php-ext-enable mongodb \
    && echo "deb [ signed-by=/usr/share/keyrings/mongodb-server-6.0.gpg ] http://repo.mongodb.org/apt/debian bullseye/mongodb-org/6.0 main" > /etc/apt/sources.list.d/mongodb-org-6.0.list \
    && curl -fsSL https:/www.mongodb.org/static/pgp/server-6.0.asc | gpg -o /usr/share/keyrings/mongodb-server-6.0.gpg --dearmor \
    && apt-get update \
    && apt-get install -y mongodb-org

WORKDIR /var/www/html

ADD . /var/www/html

CMD /var/www/html/Docker/web/start.sh
