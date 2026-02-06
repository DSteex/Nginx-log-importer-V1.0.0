<?php
declare(strict_types=1);
namespace App;

use RuntimeException;

class LogParserManager {
    public function __construct(
        private string $filePath,
        private LogParserInterface $parser,
        private LogSave $repository
    ){}

    public function run(): void {
        if (!file_exists($this->filePath)) {
            throw new RuntimeException("Файл логов не найден в: {$this->filePath}");
        }

        $handle = fopen($this->filePath, 'r');
        if (!$handle) {
            throw new RuntimeException("Ошибка при открытии файла логов");
        }
        
        while (($line = fgets($handle)) !== false) {
            $data = $this->parser->parse($line);
            if ($data) {
                $this->repository->saveData($data);
            }
        }
        fclose($handle);
    }
}