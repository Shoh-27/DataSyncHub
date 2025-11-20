# File: docker/php/Dockerfile
FROM php:8.3-fpm-alpine

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    icu-dev \
    oniguruma-dev \
    postgresql-dev \
    autoconf \
    g++ \
    make \
    openssl-dev

# Install PHP extensions
RUN docker-php-ext-install \
    pdo_mysql \
    pdo_pgsql \
    mbstring \
    zip \
    exif \
    pcntl \
    bcmath \
    intl \
    opcache

# Install Redis extension
RUN pecl install redis && docker-php-ext-enable redis

# Install MongoDB extension
RUN pecl install mongodb && docker-php-ext-enable mongodb

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy PHP configuration
COPY docker/php/php.ini /usr/local/etc/php/php.ini
COPY docker/php/php-fpm.conf /usr/local/etc/php-fpm.conf
COPY docker/php/www.conf /usr/local/etc/php-fpm.d/www.conf

# Set permissions
RUN addgroup -g 1000 www && \
    adduser -D -u 1000 -G www www && \
    mkdir -p /var/log && \
    touch /var/log/php-fpm-access.log /var/log/php-fpm-error.log && \
    chown -R www:www /var/www/html /var/log && \
    chmod -R 775 /var/log

# Switch to www user
USER www

# Expose port 9000
EXPOSE 9000

CMD ["php-fpm"]
