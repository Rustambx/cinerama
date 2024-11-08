# Установка и запуск проекта в Docker

Следуйте этим шагам для локального развертывания проекта.

## Есть 2 способа установки

# 1-Вариант

1. Для первого запуска контейнера выполните эту команду (в этой команде собраны все команды для установки):
   ```bash
   docker-compose up
    ```
   В конце установки будет надпись: "Все успешно завершено."
   Для следующих запусков контейнера используйте эту команду:
   ```bash
   docker-compose up -d 
   ```

# 2-Вариант

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
   docker exec -it new-cinerama-php bash
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

Данные пользователя с ролью Admin:<br>
Ссылка на админку: /admin

Email: admin@mail.ru <br>
Password: 12345678 <br>
Role: admin <br>
Другие пользователи после регистрации получают роль user.

## Шаги для тестирование для Docker
Для тестирование надо открыть отдельный консоль
1. Войдите в контейнер cinerama-php:
   ```bash
   docker exec -it new-cinerama-php bash
2. Внутри контейнера запустите миграцию для тестовой среды:
   ```bash
   php artisan migrate --env=testing
3. Внутри контейнера запустите тесты:
   ```bash
   php artisan test

# Установка и запуск проекта в Open Server
1. Надо создать 2 базы. Первая база для сайта. Вторая для тестирование
2. Доступ для базы сайта надо указать в файле .env
3. Доступ для базы тестирование надо указать в файле .env.testing и также в файле phpunit.xml

# После этого запустите следующие команды
1. Запустите composer:
   ```bash
   composer install
2. Запустите миграцию:
   ```bash
   php artisan migrate
3. Выполните команду для создания ролей и пользователя с ролью Admin:
   ```bash
   php artisan role:admin
4. Выполните команду для создания символической ссылки:
   ```bash
   php artisan storage:link
5. Выполните команду для создания Жанров и Фильмов:
   ```bash
   php artisan db:seed

## Шаги для тестирование для Open Server && XAMPP
1. Запустите миграцию для тестовой среды:
   ```bash
   php artisan migrate --env=testing
2. Запустите тесты:
   ```bash
   php artisan test
