#!/bin/bash

composer install --optimize-autoloader --no-dev

npm install && npm run prod

mv .env.production .env

php artisan key:generate --force

php artisan optimize

php artisan view:cache

php artisan storage:link

php artisan migrate --force

chown -R www-data:www-data vendor node_modules bootstrap/cache storage/framework/views

# exec "$@"
