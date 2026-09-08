<?php

declare(strict_types=1);

$environment = static function (string $name, string $default = ''): string {
    $value = $_ENV[$name] ?? $_SERVER[$name] ?? getenv($name);

    return $value === false || $value === null ? $default : trim((string) $value);
};

$required = static function (string $name): string {
    $value = $_ENV[$name] ?? $_SERVER[$name] ?? getenv($name);

    if ($value === false || trim($value) === '') {
        throw new RuntimeException(sprintf('%s environment variable is required.', $name));
    }

    return trim($value);
};

return [
    'class' => yii\db\Connection::class,
    'dsn' => sprintf(
        'pgsql:host=%s;port=%s;dbname=%s',
        $environment('DB_HOST', 'localhost'),
        $environment('DB_PORT', '5432'),
        $environment('DB_NAME', 'php'),
    ),
    'username' => $required('DB_USER'),
    'password' => $environment('DB_PASSWORD'),
    'charset' => 'utf8',
    'schemaMap' => [],
    'schemaCache' => false,
    'tablePrefix' => '',
    'attributes' => [
        PDO::ATTR_EMULATE_PREPARES => false,
    ],
    'defaultSchema' => $environment('DB_SCHEMA', 'public'),
];
