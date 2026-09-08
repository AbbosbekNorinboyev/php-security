<?php

declare(strict_types=1);

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

$projectRoot = dirname(__DIR__);
$autoload = $projectRoot . '/vendor/autoload.php';
$yii = $projectRoot . '/vendor/yiisoft/yii2/Yii.php';

if (!is_file($autoload) || !is_file($yii)) {
    http_response_code(503);
    header('Content-Type: text/plain; charset=utf-8');
    exit(
        "Dependencies are not installed. Run 'composer update' in the project directory, "
        . "then restart the PHP server."
    );
}

require $autoload;
require $yii;

$dotenv = Dotenv\Dotenv::createUnsafeImmutable($projectRoot);
$dotenv->safeLoad();

$config = require $projectRoot . '/config/web.php';

(new yii\web\Application($config))->run();
