<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m240318_090136_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('{{%user}}', [
            'id' => 'BINARY(16) PRIMARY KEY',
            'login' => $this->string(45)->notNull()->unique()->comment('Логин'),
            'name' => $this->string(100)->defaultValue(null)->comment('Имя'),
            'email' => $this->string(100)->notNull()->unique()->comment('Email'),
            'phone' => $this->integer()->defaultValue(null)->unique()->comment('Номер телефона'),
            'password' => $this->string(255)->notNull()->comment('Пароль в зашифрованном виде'),
            'created_date' => $this->date()->notNull()->comment('Дата создания'),
            'city_id' => 'BINARY(16)',
            'avatar_id' => 'BINARY(16)',
            'self_about' => $this->string(2000)->defaultValue(null)->comment('Пользователь сам о себе'),
            'account_details' => $this->json()->defaultValue(null)->comment('Реквизиты для вывода средств'),
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('user');
    }
}
