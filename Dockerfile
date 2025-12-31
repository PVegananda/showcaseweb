FROM php:8.2-cli

# Install extensions MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Set working directory
WORKDIR /app

# Copy source code
COPY . /app

# Expose port Railway
EXPOSE 8080

# Jalankan PHP built-in server
CMD ["php", "-S", "0.0.0.0:8080"]
