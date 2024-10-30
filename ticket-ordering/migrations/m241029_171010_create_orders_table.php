<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%orders}}`.
 */
class m241029_171010_create_orders_table extends Migration
{
    public function up()
    {
        $this->createTable('orders', [
            'id' => $this->primaryKey(),
            'event_id' => $this->integer()->notNull(),
            'event_date' => $this->dateTime()->notNull(),
            'ticket_adult_price' => $this->integer()->notNull(),
            'ticket_adult_quantity' => $this->integer()->notNull(),
            'ticket_kid_price' => $this->integer()->notNull(),
            'ticket_kid_quantity' => $this->integer()->notNull(),
            'barcode' => $this->string(120)->unique()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'equal_price' => $this->integer()->notNull(),
            'created' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    public function down()
    {
        $this->dropTable('orders');
    }
}
