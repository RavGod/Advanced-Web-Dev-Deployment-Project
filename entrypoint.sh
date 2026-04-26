#!/bin/sh

echo "Waiting for database..."

until php -r "
require '/var/www/html/db_connect.php';
getConnection();
echo 'connected';
" 2>/dev/null
do
  echo "Database not ready yet... retrying in 2 seconds"
  sleep 2
done

echo "Database is ready!"

echo "Running migrations..."
php /var/www/html/migrate.php

echo "Starting Apache..."
apache2-foreground