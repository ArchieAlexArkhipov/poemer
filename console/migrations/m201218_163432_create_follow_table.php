<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%follow}}`.
 */
class m201218_163432_create_follow_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%follow}}', [
          'id' => $this->primaryKey(),
          'userId' => $this->integer(8),
          'authorId' => $this->integer(8),
          'created' => $this->datetime(),
          'updated' => $this->datetime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%follow}}');
    }
}
