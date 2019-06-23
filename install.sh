#!/bin/sh

php artisan migrate:fresh
php artisan key:generate
php artisan passport:install
php artisan db:seed
