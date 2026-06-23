FROM php:8.2-apache

# Install system deps + PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev \
    zip unzip git curl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Enable Apache mod_rewrite
RUN a2enmod rewrite

WORKDIR /var/www/html

# Step 1: Create fresh Laravel 11 project
# Disable security advisory blocking (project is intentionally for security education)
RUN composer config --global policy.advisories.block false \
    && composer create-project laravel/laravel . "^11.0" --prefer-dist --no-interaction

# Step 2: Copy our custom vulnerable files on top
COPY routes/           routes/
COPY app/Http/         app/Http/
COPY app/Models/       app/Models/
COPY resources/        resources/
COPY database/         database/
COPY bootstrap/        bootstrap/
COPY public/           public/
COPY .env              .env

# Step 3: Generate app key & set permissions
RUN php artisan key:generate \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Apache DocumentRoot → /public (hardcoded to override Apache envvars)
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
        /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' \
        /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf \
    && echo "export APACHE_DOCUMENT_ROOT=/var/www/html/public" >> /etc/apache2/envvars

EXPOSE 80
