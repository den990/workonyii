<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use Ramsey\Uuid\Uuid;

/**
 * User model
 *
 * @property integer $id
 * @property string $login
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $password
 * @property integer $created_date
 * @property integer $city_id
 * @property integer $avatar_id
 * @property string $self_about
 * @property string $account_details
 */

class User extends ActiveRecord implements IdentityInterface
{


    public function rules()
    {
        return [
            ['login', 'required', 'message' => 'Введите логин'],
            ['email', 'required', 'message' => 'Введите email'],
            ['email', 'email', 'message' => 'Невалидный email'],
            ['email', 'unique', 'targetClass' => self::className(), 'message' => 'This email address has already been taken.'], // мб удалить
            [
                'password',
                'match',
                'pattern' => '/^(?=.*\d)(?=.*[A-Z]).{6,60}$/',
                'message' => "Пароль должен содержать хотя бы 1 цифру, букву, быть длиной от 6 до 20 символов",
                'skipOnEmpty' => false
            ],
        ];
    }

    public static function tableName()
    {
        return '{{%user}}';
    }

    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    public function setId()
    {
        $uuid = Uuid::uuid1();
        $binaryUuid = hex2bin(str_replace('-', '', $uuid));
        $this->id = $binaryUuid;
    }



    public function getId()
    {
        return bin2hex($this->id);
    }


    public static function findIdentity($id)
    {
        return static::findOne(['id' => hex2bin($id)]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // Пример реализации, если у вас есть поле для хранения токена доступа
        return static::findOne(['access_token' => $token]);
    }


    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }
}