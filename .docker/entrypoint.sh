#!/bin/bash

if [ ! -f "vendor/autoload.php" ]; then
    composer install --no-progress --no-interaction --no-dev
fi

php artisan migrate
php artisan db:seed
php artisan sync-permission
