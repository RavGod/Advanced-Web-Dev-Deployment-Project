#!/bin/bash

echo "Waiting for database..."

# Wait until Postgres is ready
until php -r "
try {
    new PDO(getenv('DATABASE_URL'));
    echo 'Connected!';
} catch (Exception \$e) {
    exit(1);
}
"; do
  echo "Database not ready yet... retrying in 2 seconds"
  sleep 2
done

echo "Database is ready!"

echo "Running migrations..."
php /var/www/html/migrate.php

echo "Starting Apache..."
apache2-foreground