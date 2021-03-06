<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * PoemLike model
 *
 * @property integer $id
 * @property integer $poemId
 * @property integer $userId
 */
class PoemLike extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'poem_like';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
      return [
          [['poemId', 'userId'], 'integer'],
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
            'userId' => 'Пользователь',
        ];
    }

    public function getPoem()
    {
      return $this->hasOne(Poem::className(), ['id' => 'poemId']);
    }

    public function getUser()
    {
      return $this->hasOne(User::className(), ['id' => 'userId']);
    }
}
