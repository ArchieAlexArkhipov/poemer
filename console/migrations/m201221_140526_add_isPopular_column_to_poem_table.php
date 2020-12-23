<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%poem}}`.
 */
class m201221_140526_add_isPopular_column_to_poem_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $this->addColumn('{{%poem}}', 'isPopular', $this->boolean()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      $this->dropColumn('{{%poem}}', 'isPopular');
    }
}
