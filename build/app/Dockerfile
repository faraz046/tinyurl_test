FROM php:8.0-apache

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

RUN a2enmod rewrite

RUN apt-get update && apt-get install -y --no-install-recommends git && \
    apt-get install -y --no-install-recommends zip && \
    apt-get install -y --no-install-recommends nano && \
    apt-get install -y --no-install-recommends unzip && \
    apt-get install -y --no-install-recommends zlib1g-dev && \
    apt-get install -y --no-install-recommends libzip-dev && \
    apt-get install -y --no-install-recommends libpng-dev


RUN docker-php-ext-install pdo_mysql zip gd

#install redis extension
RUN pecl install -o -f redis \
&&  rm -rf /tmp/pear \
&&  docker-php-ext-enable redis

### install opcache
COPY ./config/php.ini /usr/local/etc/php/php.ini
COPY ./config/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

RUN docker-php-ext-install opcache

### Installl Node
RUN curl -sL https://deb.nodesource.com/setup_16.x | bash
RUN apt-get install --yes nodejs

#COPY ../code /var/www/html

WORKDIR /var/www/html

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#RUN rm /var/www/html/bootstrap/cache/*.php
#RUN php artisan clear-compiled
#RUN php artisan config:cache