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
                'GET api/users' => 'user/list',
                'POST api/users' => 'user/create',
                'PUT api/users/<id:[a-zA-Z0-9]+>' => 'user/update',
                'DELETE api/users/<id:[a-zA-Z0-9]+>' => 'user/delete',
            ],
        ],
    ],
    'defaultRoute' => 'user/list',
    'controllerNamespace' => 'App\\Controllers',
];
