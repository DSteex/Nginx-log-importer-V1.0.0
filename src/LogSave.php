<?php
declare(strict_types=1);
namespace App;
use PDO;

class LogSave {
    public function __construct(private PDO $pdo) {}

    public function saveData(array $data): void {
        $stmt = $this->pdo->prepare("INSERT INTO logs (ip, date, method, path, status) VALUES (:ip, :date, :method, :path, :status) ON CONFLICT (ip, date, method, path) DO NOTHING");
        $stmt->execute($data);
    }
}