<?php
declare(strict_types=1);
require_once __DIR__ . '/../vendor/autoload.php';

use App\Connection;
use App\DataBase;
use App\LogParserManager;
use App\LogSave;
use App\NginxParser;

try {
    $db = (new Connection()->getConnection());

    (new DataBase($db))->createTable();
    $parser = new NginxParser();
    $repository = new LogSave($db);
    $service = new LogParserManager('/var/log/nginx/access.log', $parser, $repository);

    $service->run();

    echo "\nЛоги успешно импортированы.\n";
} catch (\Exception $e) {
    echo "Критическая ошибка: " . $e->getMessage() . "\n";
}