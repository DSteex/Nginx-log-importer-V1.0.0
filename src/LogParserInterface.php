<?php
declare(strict_types=1);
namespace App;

interface LogParserInterface {
    public function parse(string $line): ?array;
}