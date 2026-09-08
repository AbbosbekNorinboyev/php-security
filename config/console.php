<?php

declare(strict_types=1);

return [
    'id' => 'php-security-console',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'app\commands',
    'components' => [
        'db' => require __DIR__ . '/db.php',
    ],
];
