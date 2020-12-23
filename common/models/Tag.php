<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * Tag model
 *
 * @property integer $id
 * @property string $title
 * @property boolean $active
 * @property string $created
 * @property string $updated
 */
class Tag extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tag';
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
          [['title'], 'string', 'max' => 255],
          [['active'], 'boolean'],
      ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'active' => 'Активно',
            'created' => 'Создано',
            'updated' => 'Обновлено',
        ];
    }
}
