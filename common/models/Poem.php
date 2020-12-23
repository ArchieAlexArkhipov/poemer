<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * Poem model
 *
 * @property integer $id
 * @property string $title
 * @property string $text
 * @property integer $userId
 * @property boolean $isAnonymous
 * @property boolean $forAdults
 * @property boolean $isPublished
 * @property string $created
 * @property string $updated
 */
class Poem extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'poem';
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
          [['title', 'text', 'userId'], 'required', 'message' => 'Это обязательное поле'],
          [['title'], 'string', 'max' => 255],
          [['userId'], 'integer'],
          [['isAnonymous', 'forAdults', 'isPublished'], 'boolean'],
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
            'text' => 'Стих',
            'userId' => 'Автор',
            'isAnonymous' => 'Анонимно',
            'forAdults' => 'Для взрослых',
            'isPublished' => 'Опубликовано',
            'created' => 'Создано',
            'updated' => 'Обновлено',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
      return $this->hasOne(User::className(), ['id' => 'userId']);
    }

    public function getPoemTags()
    {
      return $this->hasMany(PoemTag::className(), ['poemId' => 'id']);
    }

    public function getLikes()
    {
      return $this->hasMany(PoemLike::className(), ['poemId' => 'id']);
    }

    public function getLikesCount()
    {
      return $this->hasMany(PoemLike::className(), ['poemId' => 'id'])->count();
    }

    public function getComments()
    {
      return $this->hasMany(PoemComment::className(), ['poemId' => 'id']);
    }

    public function getCommentsCount()
    {
      return $this->hasMany(PoemComment::className(), ['poemId' => 'id'])->count();
    }

    public function checkLike($userId)
    {
      $pl = PoemLike::find()->where(['poemId' => $this->id])
        ->andWhere(['userId' => $userId])->count();
      if($pl > 0) {
        return true;
      }
      return false;
    }

    public function checkBookmark($userId)
    {
      $bk = Bookmark::find()->where(['poemId' => $this->id])
        ->andWhere(['userId' => $userId])->count();
      if($bk > 0) {
        return true;
      }
      return false;
    }
}
