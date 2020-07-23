FROM php:7.4
RUN docker-php-ext-install pdo_mysql
COPY . /app
WORKDIR /app
ENTRYPOINT php artisan config:cache && php artisan migrate
