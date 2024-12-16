# Руководство по установке

**Языки:** [Русский](README.ru.md) | [English](README.md)

## Требования
- Установленный Docker и Docker Compose
- PHP >= 8.0 (если не используется Docker)
- Composer (если не используется Docker)
- MySQL >= 8.0 (если не используется Docker)

## Установка

1. Скопируйте файл `.env`:
    ```sh
    cp .env.example .env
    ```

2. Создайте Docker-сеть:
    ```sh
    docker network create exmpltask_network
    ```

3. Запустите Docker-контейнеры:
    ```sh
    docker compose up -d
    ```

4. Установите зависимости:
    ```sh
    docker compose run php composer install
    ```

5. Сгенерируйте ключ приложения:
    ```sh
    docker compose run php php artisan key:generate
    ```

6. Выполните миграции и заполните базу данных тестовыми данными:
    ```sh
    docker compose run php php artisan migrate --seed
    ```

*Убедитесь, что папка `storage` имеет права на запись:*

```sh
docker compose exec app chown -R www-data:www-data /var/www/html/storage
```

## Тестирование в Postman
Коллекция доступна по следующей ссылке:
[Коллекция Postman](LaravelTest.postman_collection.json)
