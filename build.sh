#!/bin/bash

composer install --no-dev --optimize-autoloader

npm install

npm run build

php artisan key:generate --force

php artisan migrate --force

php artisan config:clear
php artisan cache:clear

echo "Build completed successfully!"
