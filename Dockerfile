FROM php:8.2-apache

# install ekstensi mysql
RUN docker-php-ext-install mysqli pdo pdo_mysql

# aktifkan rewrite (biar aman kalau nanti pakai htaccess)
RUN a2enmod rewrite

# copy semua file project ke apache
COPY . /var/www/html/

# permission
RUN chown -R www-data:www-data /var/www/html
