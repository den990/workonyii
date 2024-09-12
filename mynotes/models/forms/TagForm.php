<?php

namespace app\models\forms;

use app\models\Tag;
use Yii;
use yii\base\Model;

class TagForm extends Tag
{


    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Name',
        ];
    }
}
