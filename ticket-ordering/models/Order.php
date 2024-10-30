<?php

namespace app\models;

use yii\db\ActiveRecord;

class Order extends ActiveRecord
{
    public static function tableName()
    {
        return 'orders';
    }

    public function rules()
    {
        return [
            [['event_id', 'event_date', 'ticket_adult_price', 'ticket_adult_quantity', 'ticket_kid_price', 'ticket_kid_quantity', 'barcode', 'user_id', 'equal_price'], 'required'],
            [['event_id', 'ticket_adult_price', 'ticket_adult_quantity', 'ticket_kid_price', 'ticket_kid_quantity', 'user_id', 'equal_price'], 'integer'],
            [['event_date', 'created'], 'safe'],
            [['barcode'], 'unique'],
        ];
    }
}