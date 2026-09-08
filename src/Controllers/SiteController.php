<?php

declare(strict_types=1);

namespace App\Controllers;

use yii\web\Controller;
use yii\web\Response;

final class SiteController extends Controller
{
    public function actionIndex(): string
    {
        return 'PHP Security with Yii2 is running.';
    }

    public function actionError(): string
    {
        $exception = \Yii::$app->errorHandler->exception;

        if ($exception === null) {
            return 'An unexpected error occurred.';
        }

        \Yii::$app->response->statusCode = $exception instanceof \yii\web\HttpException
            ? $exception->statusCode
            : Response::STATUS_INTERNAL_SERVER_ERROR;

        return YII_DEBUG ? $exception->getMessage() : 'An unexpected error occurred.';
    }
}
