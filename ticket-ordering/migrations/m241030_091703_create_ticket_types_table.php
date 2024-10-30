<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%ticket_types}}`.
 */
class m241030_091703_create_ticket_types_table extends Migration
{
    public function up()
    {
        $this->createTable('ticket_types', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull()->unique(),
            'price' => $this->integer()->notNull(),
        ]);

        // Добавляем несколько начальных записей (по желанию)
        $this->batchInsert('ticket_types', ['name', 'price'], [
            ['adult', 1000],
            ['kid', 500],
            ['privileged', 700],
            ['group', 800],
        ]);
    }

    public function down()
    {
        $this->dropTable('ticket_types');
    }
}
