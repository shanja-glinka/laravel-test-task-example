# Setup Guide

**Languages:** [Русский](README.ru.md) | [English](README.md)

## Requirements
- Docker and Docker Compose installed
- PHP >= 8.0 (if not using Docker)
- Composer (if not using Docker)
- MySQL >= 8.0 (if not using Docker)

## Installation

1. Copy the `.env` file:
    ```sh
    cp .env.example .env
    ```

2. Create a Docker network:
    ```sh
    docker network create exmpltask_network
    ```

3. Start the Docker containers:
    ```sh
    docker compose up -d
    ```

4. Install dependencies:
    ```sh
    docker compose run php composer install
    ```

5. Generate the application key:
    ```sh
    docker compose run php php artisan key:generate
    ```

6. Run database migrations and seeders:
    ```sh
    docker compose run php php artisan migrate --seed
    ```

*Make sure to give write permissions to the `storage` directory:*

```sh
docker compose exec app chown -R www-data:www-data /var/www/html/storage
```

## Testing in Postman
You can access the Postman Collection at the following link:
[Postman Collection](LaravelTest.postman_collection.json)
