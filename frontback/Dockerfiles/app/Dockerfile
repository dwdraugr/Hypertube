FROM webdevops/php-apache-dev:7.4
COPY . /app
WORKDIR /app
RUN php artisan config:cache
