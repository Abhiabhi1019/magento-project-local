FROM php:8.2-fpm

USER root

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libicu-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libxml2-dev \
    libxslt1-dev \
    libonig-dev \
    && rm -rf /var/lib/apt/lists/*

# Configure GD + Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
    intl \
    pdo_mysql \
    zip \
    gd \
    xsl \
    bcmath \
    soap \
    sockets \
    ftp

# Install Composer (official way)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ✅ IMPORTANT: Increase PHP memory (FIX YOUR ERROR)
RUN echo "memory_limit=2G" > /usr/local/etc/php/conf.d/memory-limit.ini

# ✅ OPTIONAL (recommended for Magento performance)
RUN echo "max_execution_time=1800" > /usr/local/etc/php/conf.d/max-execution.ini

WORKDIR /var/www/html
