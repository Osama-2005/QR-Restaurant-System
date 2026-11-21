# Stage 1: Build PHP environment
FROM php:8.2-apache AS base

# Install required system dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mysqli \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Stage 2: Configure application
FROM base AS production

# Set Apache document root
ENV APACHE_DOCUMENT_ROOT=/var/www/html

# Copy Apache configuration
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' \
    /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!/var/www/html/public!g' \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf

# Enable Apache rewrite module
RUN a2enmod rewrite

# Copy project files
WORKDIR /var/www/html
COPY . .

EXPOSE 80