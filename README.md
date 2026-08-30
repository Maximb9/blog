# Блог на PHP

Блог с категориями и статьями. Чистый PHP 8.2, MySQL, Smarty, SCSS, Docker.

## Стек

- PHP 8.2 + PDO
- MySQL 8
- Smarty 5
- Nginx + PHP-FPM
- SCSS

## Запуск

```bash
cp .env.example .env
mkdir -p var/cache/smarty && chmod -R 777 var
docker compose up -d --build
docker compose exec php composer install
docker compose exec php php bin/seed.php
```

Сайт: http://localhost:8080

## Страницы

- `/` — категории и 3 последние статьи в каждой
- `/category/{id}` — список статей, сортировка, пагинация
- `/article/{id}` — статья, счётчик просмотров, похожие статьи

## Структура

```
public/          — front controller
src/             — Router, Controllers, Repositories
templates/       — Smarty-шаблоны
database/        — schema.sql
bin/seed.php     — наполнение БД
scss/            — стили (сборка в public/assets/css)
```

Готовый CSS хранится в репозитории, поэтому Node.js для запуска сайта не нужен.

Для изменения стилей:

```bash
npm install
npm run build:css
```