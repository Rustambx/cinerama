# Установка и запуск проекта

Следуйте этим шагам для локального развертывания проекта.

## Шаги установки

1. Запустите Docker-контейнеры:
   ```bash
   docker-compose up -d
2. Установите зависимости composer:
   ```bash
   composer install
3. Создание файла .env на основе .env.example:
   ```bash
   php artisan generate:env
4. Войдите в контейнер cinerama-php:
   ```bash
   docker exec -it cinerama-php bash
5. Внутри контейнера запустите миграцию:
   ```bash
   php artisan migrate
6. Внутри контейнера выполните команду для создания ролей и пользователя с ролью Admin:
   ```bash
   php artisan role:admin
7. Внутри контейнера выполните команду для создания символической ссылки:
   ```bash
   php artisan storage:link
8. Внутри контейнера выполните команду для создания Жанров и Фильмов:
   ```bash
   php artisan db:seed

После выполнения 6 шага вам будет доступен пользователь:

Email: admin@mail.ru <br>
Password: 12345678 <br>
Role: admin <br>
Другие пользователи после регистрации получают роль user.

## Шаги для тестирование
1. Войдите в контейнер cinerama-php:
   ```bash
   docker exec -it cinerama-php bash
2. Внутри контейнера запустите миграцию для тестовой среды:
   ```bash
   php artisan migrate --env=testing
3. Внутри контейнера запустите тесты:
   ```bash
   php artisan test
