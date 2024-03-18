<?php

namespace app\controllers;

use app\models\PasswordReset;
use app\models\User;
use Yii;
use yii\web\Controller;

class ResetPasswordController extends Controller
{

    public function actionSendPasswordResetEmail()
    {
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();
            $modelPasswordReset = new PasswordReset();

            if (!$modelPasswordReset->load($data) || !$modelPasswordReset->validate()) {
                return false;
            }

            $user = User::findOne(['email' => $modelPasswordReset->email]);
            if (!$user) {
                return false;
            }



            return Yii::$app->mailer->compose('@app/views/site/index', ['user' => $user])
                ->setTo($modelPasswordReset->email)
                ->setFrom('koldyrev98@mail.ru')
                ->setSubject('Сброс пароля для ' . Yii::$app->name)
                ->send();
        }
    }

}