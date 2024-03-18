<?php

namespace app\controllers;

use app\models\LoginForm;
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
                    } else {
                        Yii::error("Failed to log in user: " . print_r($modelLoginForm->errors, true));
                    }
                }
                else{
                    Yii::error("User not found", true);
                }
            }
        }

//        return $this->render('@app/views/site/login', ['model' => $modelLoginForm]);
    }
}