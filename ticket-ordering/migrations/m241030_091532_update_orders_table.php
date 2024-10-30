<?php

use yii\db\Migration;

/**
 * Class m241030_091532_update_orders_table
 */
class m241030_091532_update_orders_table extends Migration
{
    public function up()
    {
        $this->dropColumn('orders', 'ticket_adult_price');
        $this->dropColumn('orders', 'ticket_adult_quantity');
        $this->dropColumn('orders', 'ticket_kid_price');
        $this->dropColumn('orders', 'ticket_kid_quantity');
        $this->dropColumn('orders', 'barcode');

    }

    public function down()
    {
        $this->addColumn('orders', 'ticket_adult_price', $this->integer()->notNull());
        $this->addColumn('orders', 'ticket_adult_quantity', $this->integer()->notNull());
        $this->addColumn('orders', 'ticket_kid_price', $this->integer()->notNull());
        $this->addColumn('orders', 'ticket_kid_quantity', $this->integer()->notNull());
        $this->addColumn('orders', 'barcode', $this->string(120)->unique()->notNull());
    }
}
