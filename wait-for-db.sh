#!/bin/bash

# Check if the database is ready
until nc -z -v -w30 db 5432
do
  echo "Esperando o banco de dados estar disponível..."
  sleep 5
done

# Run migrations after the database is ready
php artisan migrate --force
php artisan db:seed
