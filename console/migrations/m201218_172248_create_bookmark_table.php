<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bookmark}}`.
 */
class m201218_172248_create_bookmark_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%bookmark}}', [
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
        $this->dropTable('{{%bookmark}}');
    }
}
