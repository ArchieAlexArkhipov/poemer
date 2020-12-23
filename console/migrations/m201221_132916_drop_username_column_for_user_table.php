<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `{{%username_column_for_user}}`.
 */
class m201221_132916_drop_username_column_for_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $this->dropColumn('{{%user}}', 'username');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%user}}', 'username', $this->string()->notNull()->unique());
    }
}
