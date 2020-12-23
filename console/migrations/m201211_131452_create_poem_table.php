<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%poem}}`.
 */
class m201211_131452_create_poem_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%poem}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'text' => $this->text(),
            'userId' => $this->integer(8),
            'isAnonymous' => $this->boolean()->defaultValue(0),
            'forAdults' => $this->boolean()->defaultValue(0),
            'isPublished' => $this->boolean()->defaultValue(0),
            'created' => $this->datetime(),
            'updated' => $this->datetime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%poem}}');
    }
}
