<?php

declare(strict_types=1);

function getEnvOrFail(string $name): array|string
{
    $env = $_ENV[$name];
    if ($env === false || $env === '') {
        throw new RuntimeException('Mandatory environment variable ' . $name . ' is missing');
    }
    return $env;
}

$files = glob(__DIR__ . '/common/*.php');

$configParts = array_map(
    static function (string $file) {
        return require $file;
    },
    $files
);

$configParts[] = require __DIR__ . '/../src/Ticket/config.php';
$configParts[] = require __DIR__ . '/../src/TicketPost/config.php';
$configParts[] = require __DIR__ . '/../src/TicketComment/config.php';
$configParts[] = require __DIR__ . '/../src/User/config.php';
return array_merge_recursive(...$configParts);
