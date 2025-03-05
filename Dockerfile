
FROM php:8.1.27-fpm


WORKDIR /var/www/chatapp


RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libzip-dev \
    zip \
    unzip \
    nodejs \
    npm \
    libpq-dev


RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && docker-php-ext-install pdo_pgsql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy existing application directory contents
COPY . /var/www/chatapp

# Copy existing application directory permissions
COPY --chown=www-data:www-data . /var/www/chatapp

# Change the owner of the Laravel directory
RUN chmod -R 755 /var/www/chatapp/public
RUN chown -R www-data:www-data /var/www/chatapp

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
