FROM php:7.4.14-fpm
RUN apt-get update && apt-get install -y libpq-dev libsqlite3-dev zlib1g-dev libzip-dev libpng-dev libfreetype6-dev libjpeg62-turbo-dev
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install zip pdo pdo_mysql gd