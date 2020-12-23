<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%poem_tag}}`.
 */
class m201217_131000_create_poem_tag_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%poem_tag}}', [
            'id' => $this->primaryKey(),
            'poemId' => $this->integer(8),
            'tagId' => $this->integer(8),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%poem_tag}}');
    }
}
