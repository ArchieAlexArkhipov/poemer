<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

/**
 * PoemComment model
 *
 * @property integer $id
 * @property integer $poemId
 * @property integer $userId
 * @property string $text
 */
class PoemComment extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'poem_comment';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
      return [
          [
              'class' => TimestampBehavior::className(),
              'createdAtAttribute' => 'created',
              'updatedAtAttribute' => 'updated',
              'value' => new Expression('NOW()'),
          ],
      ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
      return [
          [['poemId', 'userId'], 'integer'],
          [['text'], 'string'],
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
            'text' => 'Комментарий',
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
