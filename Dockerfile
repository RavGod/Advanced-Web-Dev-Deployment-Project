FROM php:8.2-apache

# Installation and boot of all dependencies (psql does not have built-in PDO connection like MySQL does)
RUN apt-get update && apt-get install -y \
    libpq-dev \
    default-mysql-client \
    && docker-php-ext-install \
        pdo \
        pdo_pgsql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Copy project files into Apache directory
COPY src/ /var/www/html/

# Enable Apache mod_rewrite (optional but good practice)
RUN a2enmod rewrite

# Making sure to actually run 
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

CMD ["/entrypoint.sh"]