<?php
declare(strict_types=1);
namespace App;

use PDO;

class DataBase {
    public function __construct(private PDO $pdo) {}

    public function createTable(): void {
        $sql = "
            CREATE TABLE IF NOT EXISTS logs (
                id INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
                ip INET NOT NULL,
                date TIMESTAMPTZ NOT NULL,
                method VARCHAR(10) NOT NULL,
                path TEXT NOT NULL,
                status INT NOT NULL,
                CONSTRAINT logs_unique_idx UNIQUE (ip, date, method, path)
            );
        ";
        $this->pdo->exec($sql);
        echo "Таблица 'logs' успешно создана";
    }
}