<?php

namespace app\models;

use yii\base\Model;

class RegistrationForm extends Model
{
    public $login;
    public $email;
    public $password;
    public bool $agree = false;

    public $password_confirming;

    public function rules()
    {
        return [
            ['login', 'required', 'message' => 'Введите логин'],
            ['email', 'required', 'message' => 'Введите email'],
            ['email', 'email', 'message' => 'Невалидный email'],
            ['email', 'unique', 'targetClass' => self::className(), 'message' => 'Этот email используется'], // мб удалить
            [
                'password',
                'match',
                'pattern' => '/^(?=.*\d)(?=.*[A-Z]).{6,60}$/',
                'message' => "Пароль должен содержать хотя бы 1 цифру, букву, быть длиной от 6 до 20 символов",
                'skipOnEmpty' => false
            ],
            ['password_confirming', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли должны совпадать'],
            ['password_confirming', 'required', 'message' => 'Подтвердите пароль'],
            ['agree', 'required', 'requiredValue' => true, 'message' => 'Вы должны согласиться на обработку персональных данных']
        ];
    }
}