FROM php:8.2-apache

# Disable MPM event & worker
RUN a2dismod mpm_event mpm_worker || true

# Enable MPM prefork (WAJIB untuk PHP Apache)
RUN a2enmod mpm_prefork rewrite

# Install PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy source code
COPY . /var/www/html/

# Permission
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
