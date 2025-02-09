#!/usr/bin/env bash
set -ex
LANG=en_US.UTF-8

echo "$(date):  start.sh started"

## Run the laravel config file through erubis to variable substitution
erubis /var/www/html/Docker/web/env.erb > /var/www/html/.env

cd /var/www/html

if [ ! -d storage/framework ]
then
    mkdir -p storage/framework
    mkdir -p storage/framework/cache
    mkdir -p storage/framework/sessions
    mkdir -p storage/framework/views
    chmod 777 storage/framework/{cache,sessions,views}
    touch storage/logs/medusa.log
    chmod 666 storage/logs/medusa.log
fi


## Make sure we have the latest packages installed
composer --no-cache install

## Make sure we have the latest JS packages installed
npm install

## Generate the App key
php artisan key:generate

## Optimize the packages
#php artisan optimize

## Clear the cache
#php artisan cache:clear

## Run the database migrations

php-fpm
