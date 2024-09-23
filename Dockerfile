FROM php:fpm-alpine

RUN docker-php-ext-install mysqli

RUN mkdir /src/assets/static/uploads
