FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
        libzip-dev zlib1g-dev \
        libfreetype6-dev libjpeg62-turbo-dev libpng-dev \
        libsqlite3-dev libonig-dev libxml2-dev libcurl4-openssl-dev \
        mariadb-client curl sqlite3 \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo_mysql pdo_sqlite mbstring simplexml soap xml \
        zip json gd curl

RUN pecl install xdebug-2.8.1 \
    && docker-php-ext-enable xdebug

# Install Composer

RUN	curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer
RUN composer global require hirak/prestissimo

ENV PATH="/var/www/.composer/vendor/bin/:${PATH}"

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_MEMORY_LIMIT -1

# Install XDebug

RUN yes | pecl install xdebug

EXPOSE 80

WORKDIR /var/www

# CMD service php7.4-fpm start
