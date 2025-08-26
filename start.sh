#!/bin/bash

# Railway startup script that ensures environment variables are passed to Laravel

echo "Starting Case Changer Pro on Railway..."

# Clear any existing .env file to force using Railway's environment variables
rm -f .env

# Clear Laravel caches at runtime (when env vars are available)
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Start the server with Railway's PORT
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8080}