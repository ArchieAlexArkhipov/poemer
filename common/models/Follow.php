<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * Follow model
 *
 * @property integer $id
 * @property integer $userId
 * @property integer $authorId
 * @property string $created
 * @property string $updated
 */
class Follow extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'follow';
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
          [['userId', 'authorId'], 'integer'],
      ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userId' => 'Подписчик',
            'authorId' => 'Автор',
            'created' => 'Создано',
            'updated' => 'Обновлено',
        ];
    }
}
