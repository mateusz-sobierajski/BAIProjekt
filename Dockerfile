FROM php:8-apache
RUN docker-php-ext-install mysqli
RUN apt-get update && apt-get install -y \
        libpq-dev \
        && docker-php-ext-install pgsql pdo_pgsql
RUN a2enmod dav
RUN a2enmod dav_fs
WORKDIR /var/www/html