<?php

use yii\db\Migration;

/**
 * Class m240911_054700_add_vkontakte_id_to_user_table
 */
class m240911_054700_add_vkontakte_id_to_user_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'vkontakte_id', $this->integer()->unique());
    }

    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'vkontakte_id');
    }
}
