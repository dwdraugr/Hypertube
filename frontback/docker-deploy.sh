docker-compose down -v && docker-compose up -d

# команда для миграций; нужно обязательно дождаться инициализации БД
sleep 30s && docker-compose exec app bash -c "php /app/artisan migrate" &> /dev/null &
