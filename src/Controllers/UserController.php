<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Service\UserService;
use Yii;
use yii\web\Controller;
use yii\web\Response;

final class UserController extends Controller
{
    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::class,
                'actions' => [
                    'create' => ['POST'],
                ],
            ],
        ];
    }

    public function actionCreate(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $input = Yii::$app->request->getBodyParams();
        $user = (new UserService())->create($input);

        if ($user->hasErrors()) {
            Yii::$app->response->statusCode = Response::STATUS_UNPROCESSABLE_ENTITY;

            return [
                'success' => false,
                'errors' => $user->getErrors(),
            ];
        }

        Yii::$app->response->statusCode = Response::STATUS_CREATED;

        return [
            'success' => true,
            'user' => $user->toArray(),
        ];
    }
}
