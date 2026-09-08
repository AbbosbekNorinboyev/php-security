<?php

declare(strict_types=1);

return [
    'id' => 'php-security',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [],
    'components' => [
        'request' => [
            'cookieValidationKey' => getenv('APP_KEY') ?: throw new RuntimeException(
                'APP_KEY environment variable is required.',
            ),
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
