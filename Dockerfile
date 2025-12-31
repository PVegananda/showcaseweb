FROM php:8.2-apache

# === FIX TOTAL MPM APACHE ===
RUN rm -f /etc/apache2/mods-enabled/mpm_event.load \
    && rm -f /etc/apache2/mods-enabled/mpm_worker.load \
    && rm -f /etc/apache2/mods-enabled/mpm_prefork.load

RUN a2enmod mpm_prefork rewrite

# === PHP EXTENSIONS ===
RUN docker-php-ext-install mysqli pdo pdo_mysql

# === COPY SOURCE ===
COPY . /var/www/html/

# === PERMISSION ===
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
