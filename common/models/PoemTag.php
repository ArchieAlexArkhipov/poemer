<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * PoemTag model
 *
 * @property integer $id
 * @property integer $poemId
 * @property integer $tagId
 */
class PoemTag extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'poem_tag';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
      return [
          [['poemId', 'tagId'], 'integer'],
      ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'poemId' => 'Стих',
            'tagId' => 'Тег',
        ];
    }

    public function getPoem()
    {
      return $this->hasOne(Poem::className(), ['id' => 'poemId']);
    }

    public function getTag()
    {
      return $this->hasOne(Tag::className(), ['id' => 'tagId']);
    }
}
