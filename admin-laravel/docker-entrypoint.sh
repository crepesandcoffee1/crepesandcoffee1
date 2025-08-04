#!/bin/bash
set -e

# Generar APP_KEY si no existe
if [ -z "$APP_KEY" ]; then
    echo "Generating APP_KEY..."
    php artisan key:generate --show
fi

# Cache de configuración para producción
echo "Optimizing for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Ejecutar migraciones
echo "Running migrations..."
php artisan migrate --force

# Crear enlace simbólico para storage
echo "Linking storage..."
php artisan storage:link || true

# Poblar base de datos si está vacía
echo "Seeding database if needed..."
php artisan db:seed --force || true

echo "Starting application..."
exec "$@" 