FROM php:7.0-fpm

# Install Curl & GIT
RUN apt-get update && apt-get install -y curl git zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

# Install bcmath
RUN docker-php-ext-install bcmath

# Install opcache
RUN docker-php-ext-install opcache

# Install JSON
RUN docker-php-ext-install json

# Install mbstring
RUN docker-php-ext-install mbstring

# Install mcrypt
RUN apt-get update && apt-get install -y libmcrypt-dev
RUN docker-php-ext-install mcrypt

# Install intl
RUN apt-get update && apt-get install -y libicu-dev
RUN docker-php-ext-install intl

# mongo needs libssl as dep
RUN apt-get install -y libssl-dev

# Install mongodb ext
RUN pecl install mongodb
RUN docker-php-ext-enable mongodb

COPY php.ini /usr/local/etc/php/php.ini
COPY php-fpm.conf /usr/local/etc/php-fpm.d/

RUN mkdir -p ~/.ssh && ssh-keyscan github.com >> ~/.ssh/known_hosts

# Change the www-data user to ID 1000
RUN usermod -u 1000 www-data

EXPOSE 9000

VOLUME /var/www

WORKDIR /var/www

CMD ["php-fpm"]
