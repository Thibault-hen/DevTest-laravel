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

# Env
if [ ! -f .env ]; then
    cp .env.example .env
fi
php artisan key:generate --force
npm install concurrently --save-dev
# Migrate & seed
php artisan migrate:fresh --seed

# Storage link
rm -f public/storage
php artisan storage:link

php-fpm &

composer dev