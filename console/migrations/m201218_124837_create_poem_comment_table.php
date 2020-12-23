<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%poem_comment}}`.
 */
class m201218_124837_create_poem_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%poem_comment}}', [
            'id' => $this->primaryKey(),
            'poemId' => $this->integer(8),
            'userId' => $this->integer(8),
            'text' => $this->text(),
            'created' => $this->datetime(),
            'updated' => $this->datetime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%poem_comment}}');
    }
}
