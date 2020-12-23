<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%poem_like}}`.
 */
class m201218_115851_create_poem_like_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%poem_like}}', [
            'id' => $this->primaryKey(),
            'poemId' => $this->integer(8),
            'userId' => $this->integer(8),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%poem_like}}');
    }
}
