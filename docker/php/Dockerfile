FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
git \
curl \
zip \
unzip \
libicu-dev \
libzip-dev \
libpng-dev \
libjpeg62-turbo-dev \
libfreetype6-dev \
libxml2-dev \
libxslt1-dev

# Configure GD with JPEG support
RUN docker-php-ext-configure gd \
--with-freetype \
--with-jpeg

RUN docker-php-ext-install \
pdo \
pdo_mysql \
intl \
zip \
bcmath \
soap \
sockets \
ftp \
xsl \
gd

WORKDIR /var/www/html
