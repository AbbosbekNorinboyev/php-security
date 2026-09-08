<?php

declare(strict_types=1);

$required = static function (string $name): string {
    $value = getenv($name);

    if ($value === false || trim($value) === '') {
        throw new RuntimeException(sprintf('%s environment variable is required.', $name));
    }

    return trim($value);
};

return [
    'class' => yii\db\Connection::class,
    'dsn' => sprintf(
        'pgsql:host=%s;port=%s;dbname=%s',
        getenv('DB_HOST') ?: 'localhost',
        getenv('DB_PORT') ?: '5432',
        getenv('DB_NAME') ?: 'php'
    ),
    'username' => $required('DB_USER'),
    'password' => getenv('DB_PASSWORD') ?: '',
    'charset' => 'utf8',
    'schemaMap' => [],
    'schemaCache' => false,
    'tablePrefix' => '',
    'attributes' => [
        PDO::ATTR_EMULATE_PREPARES => false,
    ],
    'defaultSchema' => getenv('DB_SCHEMA') ?: 'public',
];
