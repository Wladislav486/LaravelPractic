# Запуск приложения

1. cp .env.example .env
2. docker-compose build app
3. docker-compose up -d
4. docker-compose exec app composer install
5. docker-compose exec app php artisan migrate


