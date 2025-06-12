FROM php:8.3-apache

RUN docker-php-ext-install pdo pdo_mysql mysqli

RUN pecl install mongodb && docker-php-ext-enable mongodb

RUN a2enmod rewrite

COPY ./public /var/www/html

COPY ./config /var/www/config
COPY ./controllers /var/www/controllers
COPY ./helpers /var/www/helpers
COPY ./views /var/www/views
COPY ./scripts /var/www/scripts
COPY ./src /var/www/src
COPY ./vendor /var/www/vendor

RUN chown -R www-data:www-data /var/www

RUN echo "SetEnv APP_ENV local" >> /etc/apache2/apache2.conf
