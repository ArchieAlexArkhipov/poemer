<?php

use yii\db\Migration;

/**
 * Class m201217_131311_insert_data_to_tag_table
 */
class m201217_131311_insert_data_to_tag_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      Yii::$app->db->createCommand()->batchInsert('tag', ['title', 'active'], [
        ['На русском', 1],
        ['На английском', 1],
        ['О любви', 1],
        ['Для детей', 1],
        ['О жизни', 1],
        ['О природе', 1],
        ['О дружбе', 1],
        ['О женщине', 1],
        ['О девушке', 1],
        ['Короткие', 1],
        ['Грустные', 1],
        ['Про осень', 1],
        ['Про зиму', 1],
        ['О весне', 1],
        ['Про лето', 1],
        ['Смешные', 1],
        ['Матерные', 1],
        ['С добрым утром', 1],
        ['Спокойной ночи', 1],
        ['Про семью', 1],
        ['О маме', 1],
        ['Про папу', 1],
        ['Про бабушку', 1],
        ['Про дедушку', 1],
        ['О войне', 1],
        ['О родине', 1],
        ['Про армию', 1],
        ['Про школу', 1],
        ['О музыке', 1],
        ['Для малышей', 1],
        ['О доброте', 1],
        ['На конкурс', 1],
        ['Сказка', 1],
      ])->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201217_131311_insert_data_to_tag_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201217_131311_insert_data_to_tag_table cannot be reverted.\n";

        return false;
    }
    */
}
