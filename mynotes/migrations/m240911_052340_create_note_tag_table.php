<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%note_tag}}`.
 */
class m240911_052340_create_note_tag_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%note_tag}}', [
            'id' => $this->primaryKey(),
            'note_id' => $this->integer()->notNull(),
            'tag_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-note_tag-note_id',
            'note_tag',
            'note_id',
            'note',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-note_tag-tag_id',
            'note_tag',
            'tag_id',
            'tag',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%note_tag}}');
    }
}
