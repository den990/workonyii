<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\authclient\AuthAction;
use app\models\User;

class AuthController extends Controller
{
    public function actions()
    {
        return [
            'auth' => [
                'class' => AuthAction::class,
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    public function onAuthSuccess($client)
    {
        $attributes = $client->getUserAttributes();
        file_put_contents('att.txt', print_r($attributes, true));
        /* @var $user User */
        $user = User::find()->where(['vkontakte_id' => $attributes['id']])->one();

        if (!$user) {
            // Новый пользователь, создаём его
            $user = new User([
                'username' => $attributes['first_name'] . ' ' . $attributes['last_name'],
                'vkontakte_id' => $attributes['id'],
                'auth_key' => Yii::$app->security->generateRandomString(),
                'password_hash' => Yii::$app->security->generatePasswordHash(Yii::$app->security->generateRandomString(8)),
            ]);
            file_put_contents('test.txt', print_r($user, true));
            $user->save();
            file_put_contents('test1.txt', print_r($user->errors, true));
        }

        Yii::$app->user->login($user, 3600 * 24 * 30); // Вход на 30 дней

        return $this->goHome();
    }
}
