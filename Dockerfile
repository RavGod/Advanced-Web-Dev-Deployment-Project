FROM php:8.2-apache

# Install PDO MySQL extension
RUN docker-php-ext-install pdo pdo_pgsql pdo_mysql

# Copy project files into Apache directory
COPY src/ /var/www/html/

# Enable Apache mod_rewrite (optional but good practice)
RUN a2enmod rewrite