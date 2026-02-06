<?php
declare(strict_types=1);
namespace App;

use PDO;
use PDOException;

class Connection {
    private ?PDO $connection = null;

    public function getConnection(): PDO {
        if ($this->connection === null) {
            $host = getenv('DB_HOST') ?: 'db';
            $db = getenv('POSTGRES_DB');
            $user = getenv('POSTGRES_USER');
            $pass = getenv('POSTGRES_PASSWORD');
            $port = getenv('DB_PORT') ?: '5432';

            if (!$db || !$user || !$pass) {
                throw new \RuntimeException("Отсутствуют данные БД в .env");
            }

            $dsn = "pgsql:host=$host;port=$port;dbname=$db";

            try {
                $this->connection = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => false,]);
            } catch (PDOException $e) {
                error_log("DB connection error: " . $e->getMessage());
                throw new \RuntimeException("Ошибка подключения к БД");
            }
        }

        return $this->connection;
    }
}