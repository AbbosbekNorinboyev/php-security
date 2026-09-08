<?php

declare(strict_types=1);

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

$projectRoot = dirname(__DIR__);
$autoload = $projectRoot . '/vendor/autoload.php';
$yii = $projectRoot . '/vendor/yiisoft/yii2/Yii.php';

if (!is_file($autoload) || !is_file($yii)) {
    header('Content-Type: text/plain; charset=utf-8');
    echo "Yii2 dependency is missing.\n\n";
    echo "Run these commands in the project directory:\n";
    echo "  composer update --no-interaction\n";
    echo "  composer dump-autoload\n\n";
    echo "Expected file:\n";
    echo "  {$yii}\n";
    exit;
}

require $autoload;
require $yii;

$dotenv = Dotenv\Dotenv::createUnsafeImmutable($projectRoot);
$dotenv->safeLoad();

if (!is_file($projectRoot . '/.env')) {
    header('Content-Type: text/plain; charset=utf-8');
    echo "The .env file is missing.\n\n";
    echo "Create it with:\n";
    echo "  Copy-Item .env.example .env\n";
    exit;
}

$config = require $projectRoot . '/config/web.php';

(new yii\web\Application($config))->run();
