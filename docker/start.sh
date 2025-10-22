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
    php artisan key:generate --force
fi

# Migrate & seed
php artisan migrate:fresh --seed

# Storage link
rm -f public/storage
php artisan storage:link


# 6️⃣ Start PHP-FPM in background (so Nginx can connect)
php-fpm &

# 7️⃣ Start Laravel queue worker in background
php artisan queue:listen --tries=1 &

# 8️⃣ Start Vite dev server in foreground
npm run dev