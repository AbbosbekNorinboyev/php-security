<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\User;
use App\Service\UserService;
use Yii;
use yii\web\Controller;
use yii\web\Response;

final class UserController extends Controller
{
    public function actions(): array
    {
        return [];
    }

    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::class,
                'actions' => [
                    'create' => ['POST'],
                    'list' => ['GET'],
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
            Yii::$app->response->statusCode = 422;

            return [
                'success' => false,
                'errors' => $user->getErrors(),
            ];
        }

        Yii::$app->response->statusCode = 201;

        return [
            'success' => true,
            'user' => $user->toArray(),
        ];
    }

    public function actionList(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $users = (new UserService())->list();

        return [
            'success' => true,
            'users' => array_map(
                static fn (User $user): array => $user->toArray(),
                $users,
            ),
        ];
    }
}
