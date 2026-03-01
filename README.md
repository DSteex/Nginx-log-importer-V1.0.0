# Nginx Log Importer V1.0.0

Инструмент на PHP 8.4 для парсинга логов Nginx и их импорта в базу данных PostgreSQL.
Проект полностью контейнеризирован с помощью Docker.

A PHP 8.4 tool for parsing Nginx logs and importing them into a PostgreSQL database.
The project is fully containerized using Docker.

## Структура проекта / Project structure

### src/
- **Connection.php** — Подключение к PostgreSQL через PDO / PostgreSQL connection via PDO.
- **DataBase.php** — Автоматическое создание таблицы `logs` при запуске / Auto-creation of the logs table.
- **LogParserInterface.php** — Интерфейс для создания кастомных парсеров / Custom parser interface.
- **NginxParser.php** — Реализация парсера / Parser implementation.
- **LogSave.php** — Сохранение распарсенных данных в БД / Database persistence logic.
- **LogParserManager.php** — Главный сервис, связывающий чтение файла, парсинг, проверку файла и сохранение / Main service: reading, parsing, validation, and saving.

### bin/
- **run.php** — Консольный скрипт для запуска процесса миграции и импорта / CLI script to run the import.

## Установка / Install (Ubuntu)

1. **Клонирование / Cloning**

    git clone https://github.com/DSteex/Nginx-log-importer-V1.0.0.git

    cd Nginx-log-importer-V1.0.0

2. **Настройка .env / Config .env**

    Переименовать .evn.example в .env и изменить параметры по своему усмотрению
    Rename .env.example to .env and modify parameters as needed.

3. **Сборка контейнеров / Building containers**

    docker compose up -d --build

4. **Установка PHP-зависимостей / Installing PHP dependencies**

    docker exec -it log_importer_app composer install

5. **Инициализация БД / Database initialization**

    docker exec -it log_importer_app php src/DataBase.php

6. **Экспорт данных из .env в контейнер / Exporting .env to container**

    export $(cat .env | xargs)


## Запуск

1. **Запуск / Usage**

    docker exec -it log_importer_app php bin/run.php

2. **Проверка записей в БД (bash) / Checking database records**

    docker exec -it log_analyze_db psql -U ${POSTGRES_USER} -d ${POSTGRES_DB} -c "SELECT * FROM Logs;"