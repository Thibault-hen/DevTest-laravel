#!/bin/sh
set -e

# Composer
if [ ! -f vendor/autoload.php ]; then
    echo "Installing PHP dependencies..."
    composer install --no-interaction
fi

# NPM / Vite
if [ ! -f node_modules/.bin/vite ]; then
    echo "Installing JS dependencies..."
    npm install
fi

if [ ! -f .env ]; then
    cp .env.example .env
fi

php artisan key:generate --force
npm install concurrently --save-dev
php artisan migrate:fresh --seed

rm -f public/storage
php artisan storage:link

chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache

php-fpm &

composer dev