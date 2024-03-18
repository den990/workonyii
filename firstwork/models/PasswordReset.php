<?php

namespace app\models;

use yii\base\Model;

class PasswordReset extends Model
{

    public $password;
    public $password_confirming;

    public function rules()
    {
        return [
            [
                'password',
                'match',
                'pattern' => '/^(?=.*\d)(?=.*[A-Z]).{6,60}$/',
                'message' => "Пароль должен содержать хотя бы 1 цифру, букву, быть длиной от 6 до 20 символов",
                'skipOnEmpty' => false
            ],
            [['password', 'password_confirming'], 'required', 'message' => 'Введите email'],
            ['password_confirming', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли должны совпадать'],
        ];
    }
}