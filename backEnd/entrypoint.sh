#!/bin/sh

if [ ! -f "/var/www/html/.env" ]; then
    cp .env.example .env
fi

php artisan key:generate --force

php artisan migrate --seed --force

exec "$@"
