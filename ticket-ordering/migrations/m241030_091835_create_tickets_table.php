<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tickets}}`.
 */
class m241030_091835_create_tickets_table extends Migration
{
    public function up()
    {
        $this->createTable('tickets', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'ticket_type_id' => $this->integer()->notNull(),
            'barcode' => $this->string(120)->notNull()->unique(),
        ]);

        $this->addForeignKey(
            'fk-tickets-order_id',
            'tickets',
            'order_id',
            'orders',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-tickets-ticket_type_id',
            'tickets',
            'ticket_type_id',
            'ticket_types',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk-tickets-order_id', 'tickets');
        $this->dropForeignKey('fk-tickets-ticket_type_id', 'tickets');
        $this->dropTable('tickets');
    }
}
