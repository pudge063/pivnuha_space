FROM php:fpm-alpine

# Установим необходимые зависимости и расширения
RUN apk add --no-cache \
        libpng-dev \
        libjpeg-turbo-dev \
        libwebp-dev \
        libxpm-dev \
        && docker-php-ext-configure gd \
            --with-jpeg \
            --with-webp \
            --with-xpm \
        && docker-php-ext-install gd \
        && docker-php-ext-install mysqli pdo pdo_mysql

# Устанавливаем рабочую директорию
WORKDIR /var/www/html

# Копируем файлы проекта (это может быть не обязательно, если используете volume в docker-compose)
COPY ./src /var/www/html

# Настройка прав доступа (если нужно)
RUN chown -R www-data:www-data /var/www/html
