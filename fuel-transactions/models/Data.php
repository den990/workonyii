<?php

namespace app\models;

use yii\db\ActiveRecord;

class Data extends ActiveRecord
{
    public static function tableName()
    {
        return 'data';
    }
}