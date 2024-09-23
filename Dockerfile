FROM php:fpm-alpine

RUN docker-php-ext-install mysqli

# RUN mkdir /src/assets/static/uploads
RUN chown -R www-data:www-data /var/www/html
