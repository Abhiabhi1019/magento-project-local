FROM php:8.2-fpm

USER root

# ── System dependencies ──────────────────────────────────────────────────────
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

# ── PHP extensions required by Magento 2 ────────────────────────────────────
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
        ftp \
        opcache

# ── PHP INI tuning ────────────────────────────────────────────────────────────
RUN { \
    echo "memory_limit=2G"; \
    echo "max_execution_time=1800"; \
    echo "upload_max_filesize=64M"; \
    echo "post_max_size=64M"; \
    echo "realpath_cache_size=10M"; \
    echo "realpath_cache_ttl=7200"; \
} > /usr/local/etc/php/conf.d/magento.ini

# ── OPcache tuning (speeds up Magento significantly) ─────────────────────────
RUN { \
    echo "opcache.enable=1"; \
    echo "opcache.memory_consumption=512"; \
    echo "opcache.interned_strings_buffer=64"; \
    echo "opcache.max_accelerated_files=60000"; \
    echo "opcache.revalidate_freq=0"; \
    echo "opcache.fast_shutdown=1"; \
    echo "opcache.enable_cli=1"; \
} > /usr/local/etc/php/conf.d/opcache.ini

# ── Composer (official multi-stage copy) ─────────────────────────────────────
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# ── Working directory & ownership ─────────────────────────────────────────────
# www-data is UID 33 / GID 33 in Debian-based images.
# Pre-creating the directory and setting ownership means Docker named volumes
# will inherit the correct owner on first mount.
RUN mkdir -p /var/www/html \
    && chown -R www-data:www-data /var/www/html

WORKDIR /var/www/html

EXPOSE 9000

# Drop to www-data so all runtime file operations are done as the web user
USER www-data
