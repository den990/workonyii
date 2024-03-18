<?php

namespace app\models;

use yii\base\Model;

class PasswordResetForm extends Model
{
    public $email;
    public function rules()
    {
        return [
            ['email', 'email', 'message' => 'Невалидный email'],
            ['email', 'required', 'message' => 'Введите email']
        ];
    }
}