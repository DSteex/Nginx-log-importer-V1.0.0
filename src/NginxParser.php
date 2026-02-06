<?php
declare(strict_types=1);
namespace App;

use DateTime;

class NginxParser implements LogParserInterface {

    private const LOG_PATTERN = '/^(?<ip>\S+) \S+ \S+ \[(?<date>.*?)\] "(?<method>\S+) (?<path>\S+) \S+" (?<status>\d+)/';

    private function formatDate(string $date): string {
        $dt = DateTime::createFromFormat('d/M/Y:H:i:s O', $date);
        return $dt ? $dt->format('Y-m-d H:i:sO') : date('Y-m-d H:i:sO');
    }

    public function parse(string $line): ?array {
        if (!preg_match(self::LOG_PATTERN, $line, $m)) {
           return null;
        }
        
        return [
            'ip' => $m['ip'],
            'date' => $this->formatDate($m['date']),
            'method' => $m['method'],
            'path' => $m['path'],
            'status' => (int)$m['status']
        ];
    }
}