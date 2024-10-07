# Use PHP base image with Alpine
FROM php:8.3-fpm-alpine3.19

# Install system dependencies
RUN apk add --no-cache \
    bash \
    curl \
    libpng-dev \
    libzip-dev \
    zlib-dev \
    postgresql-dev

# Install required PHP extensions for Laravel and PostgreSQL
RUN docker-php-ext-install gd \
    && docker-php-ext-install zip \
    && docker-php-ext-install pdo pdo_pgsql

# Get the latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install node and npm
RUN apk add --no-cache nodejs npm


RUN adduser -D appuser

# Set working directory
WORKDIR /var/www

# Copy the project files to the container
COPY . .

RUN mkdir -p /var/www/storage/logs \
    && chown -R www-data:www-data /var/www/storage \
    && chmod -R 775 /var/www/storage

RUN chown -R appuser:www-data /var/www && chmod -R 775 /var/www
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache


RUN composer config --global process-timeout 2000


RUN composer install --no-interaction --prefer-dist --optimize-autoloader -vvv

# Generate Laravel application key
RUN php artisan key:generate

# Expose port 9000
EXPOSE 9000

# Startup command
CMD ["php-fpm"]
