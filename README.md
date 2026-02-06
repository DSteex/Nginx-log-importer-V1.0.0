# Nginx Log Importer V1.0.0

Инструмент на PHP 8.4 для парсинга логов Nginx и их импорта в базу данных PostgreSQL.
Проект полностью контейнеризирован с помощью Docker.

## Структура проекта

### src/
- **Connection.php** — Подключение к PostgreSQL через PDO.
- **DataBase.php** — Автоматическое создание таблицы `logs` при запуске.
- **LogParserInterface.php** — Интерфейс для создания кастомных парсеров.
- **NginxParser.php** — Реализация парсера.
- **LogSave.php** — Сохранение распарсенных данных в БД.
- **LogParserManager.php** — Главный сервис, связывающий чтение файла, парсинг, проверку файла и сохранение.

### bin/
- **run.php** — Консольный скрипт для запуска процесса миграции и импорта.

## Установка (Ubuntu)

1. **Клонирование:**

    git clone https://github.com/DSteex/Nginx-log-importer-V1.0.0.git

    cd Nginx-log-importer-V1.0.0

2. **Настройка .env**

     Переименовать .evn.example в .env и изменить параметры по своему усмотрению

3. **Сборка контейнеров**

    docker compose up -d --build

4. **Установка PHP-зависимостей**

    docker exec -it log_importer_app composer install

5. **Инициализация БД**

    docker exec -it log_importer_app php src/DataBase.php

6. **Экспорт данных из .env в контейнер

    export $(cat .env | xargs)


## Запуск

1. **Запуск парсера логов**

    docker exec -it log_importer_app php bin/run.php

2. **Проверка записей в БД (bash)**

    docker exec -it log_analyze_db psql -U ${POSTGRES_USER} -d ${POSTGRES_DB} -c "SELECT * FROM Logs;"