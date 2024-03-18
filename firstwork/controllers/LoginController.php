<?php

namespace app\controllers;

use app\models\LoginForm;
use app\models\PasswordResetForm;
use app\models\User;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class LoginController extends Controller
{

    public function actionLogin()
    {
        $modelLoginForm = new LoginForm();

        if (Yii::$app->request->isPost)
        {
            $data = Yii::$app->request->post();
            if ($modelLoginForm->load($data) && $modelLoginForm->validate())
            {
                $user = User::findOne(['email' => $modelLoginForm->email]);
                if ($user !== null)
                {
                    if ($modelLoginForm->login()) {
                        return $this->goHome();
                    }
                }
            }
        }

        $modelPasswordReset = new PasswordResetForm();
        return $this->render('@app/views/site/login',
            ['model' => $modelLoginForm, 'modelPasswordReset' => $modelPasswordReset]);
    }
}