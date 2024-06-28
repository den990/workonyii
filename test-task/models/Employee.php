<?php

namespace app\models;

use yii\db\ActiveRecord;

class Employee extends ActiveRecord
{
    public static function tableName()
    {
        return 'employee';
    }

    public function rules()
    {
        return [
            [['name', 'email', 'attestation_date'], 'required'],
            [['name', 'email'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['attestation_date'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }
}