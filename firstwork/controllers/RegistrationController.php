<?php

namespace app\controllers;

use app\models\User;
use yii\web\Controller;
use Yii;
use Ramsey\Uuid\Uuid;

class RegistrationController extends Controller
{
    public function actionRegistration()
    {
        if (Yii::$app->request->isPost)
        {
            $modelUser = new User();
            $data = Yii::$app->request->post();

            $modelUser->load($data, 'RegistrationForm');

            $modelUser->created_date = date('Y-m-d H:i:s', strtotime('now'));
            $modelUser->setPassword($modelUser->password);
            $modelUser->setId();

            if (!$modelUser->save())
            {
                Yii::error("Error saving User model: " . print_r($modelUser->errors, true), 'app\controllers\RegistrationController');
            }
            else
            {
                return $this->redirect(['site/login']);
            }
        }
    }
}