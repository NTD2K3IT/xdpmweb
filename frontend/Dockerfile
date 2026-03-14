FROM php:8.2-cli

WORKDIR /var/www

RUN apt-get update && apt-get install -y git unzip curl

RUN docker-php-ext-install pdo pdo_mysql

COPY . .

RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

RUN composer install

CMD php artisan serve --host=0.0.0.0 --port=$PORT