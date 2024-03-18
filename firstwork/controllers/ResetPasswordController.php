<?php

namespace app\controllers;

use app\models\PasswordReset;
use app\models\PasswordResetForm;
use app\models\User;
use Yii;
use yii\web\Controller;

class ResetPasswordController extends Controller
{

    public function actionSendPasswordResetEmail()
    {
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();
            $modelPasswordReset = new PasswordResetForm();

            if (!$modelPasswordReset->load($data) || !$modelPasswordReset->validate()) {
                return false;
            }

            $user = User::findOne(['email' => $modelPasswordReset->email]);
            if (!$user) {
                return false;
            }



            Yii::$app->mailer->compose('@app/views/site/index', ['user' => $user])
                ->setTo($modelPasswordReset->email)
                ->setFrom('koldyrev98@mail.ru')
                ->setSubject('Сброс пароля, ' . $user->login)
                ->setHtmlBody('<p>Перейдите по следующей ссылке для сброса пароля: <a href="' . Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'password' => $user->password]) . '">Ссылка</a></p>')
                ->send();

            return $this->redirect(['site/login']);
        }
    }

    public function actionResetPassword()
    {
        $passwordHash = Yii::$app->request->get('password');
        if ($passwordHash)
        {
            if (Yii::$app->request->isPost) {
                $data = Yii::$app->request->post();
                $modelPasswordReset = new PasswordReset();
                $modelPasswordReset->load($data);

                $user = User::findOne(['password' => $passwordHash]);
                if ($user)
                {
                    $user->setPassword($modelPasswordReset->password);

                    if (!$user->save())
                    {
                        Yii::error("Error saving User model: " . print_r($user->errors, true), 'app\controllers\ResetPasswordController');
                    }
                    else
                    {
                        return $this->redirect(['site/login']);
                    }
                }
                else
                {
                    Yii::$app->response->redirect(Yii::$app->homeUrl)->send();
                    Yii::$app->end();
                }

            }
        }
    }

}
?>