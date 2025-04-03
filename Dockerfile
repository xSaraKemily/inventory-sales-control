FROM php:8.3-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libssl-dev \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Instale o Composer separadamente
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd sockets

# install sqlite
RUN apt-get update && apt-get install -y libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite


# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# install tzdata package to manage timezones -> set EST timezone
RUN apt-get update && apt-get install -y tzdata
RUN cp /usr/share/zoneinfo/America/Sao_Paulo /etc/localtime
RUN echo "America/Sao_Paulo" > /etc/timezone
RUN dpkg-reconfigure -f noninteractive tzdata

# Set working directory
WORKDIR /var/www

# Copy project files to container
COPY . /var/www

# Copy custom configurations PHP
#COPY docker/php/custom.ini /usr/local/etc/php/conf.d/custom.ini

# Make artisan executable
RUN chmod +x /var/www/artisan

RUN mkdir -p bootstrap/cache && \
    chown -R www-data:www-data bootstrap/cache && \
    chmod -R 775 bootstrap/cache

USER root
