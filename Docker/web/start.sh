#!/usr/bin/env bash
set -ex
LANG=en_US.UTF-8

echo "$(date):  start.sh started"

## Run the laravel config file through erubis to variable substitution
erubis /var/www/html/Docker/web/env.erb > /var/www/html/.env

cd /var/www/html

mkdir storage/framework
mkdir storage/framework/cache
mkdir storage/framework/sessions
mkdir storage/framework/views
chmod 777 storage/framework/{cache,sessions,views}


## Make sure we have the latest packages installed
composer install

## Make sure we have the latest JS packages installed
npm install

## Generate the App key
php artisan key:generate

## Run the database migrations
php artisan migrate

php-fpm
