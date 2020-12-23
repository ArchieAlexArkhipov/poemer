<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%user}}`.
 */
class m201217_160155_add_columns_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $this->addColumn('{{%user}}', 'name', $this->string(255));
      $this->addColumn('{{%user}}', 'surname', $this->string(255));
      $this->addColumn('{{%user}}', 'image', $this->string(255)->defaultValue('default_user.jpg'));
      $this->addColumn('{{%user}}', 'about', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      $this->dropColumn('{{%user}}', 'name');
      $this->dropColumn('{{%user}}', 'surname');
      $this->dropColumn('{{%user}}', 'image');
      $this->dropColumn('{{%user}}', 'about');
    }
}
