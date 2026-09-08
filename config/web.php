<?php

declare(strict_types=1);

return [
    'id' => 'php-security',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [],
    'components' => [
        'request' => [
            'enableCookieValidation' => false,
            'enableCsrfValidation' => false,
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
            'rules' => [
                'GET users' => 'user/list',
                'POST users' => 'user/create',
            ],
        ],
    ],
    'defaultRoute' => 'user/list',
    'controllerNamespace' => 'App\\Controllers',
];
