<?php

declare(strict_types=1);

$appKey = $_ENV['APP_KEY'] ?? $_SERVER['APP_KEY'] ?? getenv('APP_KEY') ?: '';

return [
    'id' => 'php-security',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [],
    'components' => [
        'request' => [
            'cookieValidationKey' => $appKey !== '' ? $appKey : throw new RuntimeException(
                'APP_KEY environment variable is required.',
            ),
            'parsers' => [
                'application/json' => yii\web\JsonParser::class,
            ],
        ],
        'db' => require __DIR__ . '/db.php',
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
    ],
    'defaultRoute' => 'site/index',
    'controllerNamespace' => 'App\\Controllers',
];
