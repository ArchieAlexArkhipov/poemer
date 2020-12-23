<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\web\Response;
use yii\data\ActiveDataProvider;
use \common\models\User;
use \common\models\Poem;
use \common\models\Tag;
use \common\models\PoemTag;

/**
 * Poems controller
 */
class PoemsController extends Controller
{

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionBest($id = 0)
    {

      $query = Poem::find()
        ->where(['poem.isPublished' => true])
        ->andWhere(['poem.isPopular' => true])
        ->orderBy('created DESC');

      $dataProvider = new ActiveDataProvider([
        'query' => $query,
        'pagination' => [
          'pageSize' => 30,
        ],
      ]);

      return $this->render('best', [
        'dataProvider' => $dataProvider,
      ]);
    }


    public function actionFollows($id = 0)
    {
      if (Yii::$app->getUser()->isGuest) {
        return $this->redirect(['/' . Yii::$app->getUser()->loginUrl]);
      }
      $followAuthors = User::find()
        ->leftJoin('follow', 'follow.authorId = user.id')
          // ->where(['follow.isPublished' => true])
          ->andWhere(['follow.userId' => Yii::$app->getUser()->getId()])
        ->all();

      $followAuthors = array_column($followAuthors, 'id');

      $query = Poem::find()
          ->where(['poem.isPublished' => true])
          ->andWhere(['IN','poem.userId', $followAuthors])
        ->orderBy('created DESC');

      $dataProvider = new ActiveDataProvider([
        'query' => $query,
        'pagination' => [
          'pageSize' => 30,
        ],
      ]);

      return $this->render('follows', [
        'dataProvider' => $dataProvider,
      ]);
    }

    public function actionBookmarks($id = 0)
    {
      if (Yii::$app->getUser()->isGuest) {
        return $this->redirect(['/' . Yii::$app->getUser()->loginUrl]);
      }
      $query = Poem::find()
        ->innerJoin('bookmark', 'bookmark.poemId = poem.id')
          ->where(['poem.isPublished' => true])
          ->andWhere(['IN','bookmark.userId', Yii::$app->getUser()->getId()])
        ->orderBy('created DESC');


      $dataProvider = new ActiveDataProvider([
        'query' => $query,
        'pagination' => [
          'pageSize' => 30,
        ],
      ]);

      return $this->render('bookmarks', [
        'dataProvider' => $dataProvider,
      ]);
    }

    public function actionTag($id)
    {
      $tag = Tag::findOne($id);
      if(!is_object($tag)) {
        throw new NotFoundHttpException();
      }

      $query = Poem::find()
        ->innerJoin('poem_tag', 'poem_tag.poemId = poem.id')
        ->where(['poem.isPublished' => true])
        ->andWhere(['poem_tag.tagId' => $id])
        ->orderBy('created DESC');

      $dataProvider = new ActiveDataProvider([
        'query' => $query,
        'pagination' => [
          'pageSize' => 30,
        ],
      ]);

      return $this->render('tag', [
        'dataProvider' => $dataProvider,
        'tag' => $tag,
      ]);
    }

    public function actionSearch()
    {
      if(isset($_GET['query'])) {
        $searchQuery = htmlspecialchars(trim($_GET['query']));

        $query = Poem::find()
          ->where(['poem.isPublished' => true])
          ->andWhere(['OR',
               ['LIKE', 'poem.title', $searchQuery],
               ['LIKE', 'poem.text', $searchQuery]
           ])
          ->orderBy('created DESC');

        $dataProvider = new ActiveDataProvider([
          'query' => $query,
          'pagination' => [
            'pageSize' => 30,
          ],
        ]);

        return $this->render('search', [
          'dataProvider' => $dataProvider,
          'searchQuery' => $searchQuery,
        ]);
      } else {
        throw new NotFoundHttpException();
      }
    }
}
