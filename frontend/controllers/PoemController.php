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
use \common\models\PoemLike;
use \common\models\PoemComment;
use \common\models\Bookmark;

/**
 * Poem controller
 */
class PoemController extends Controller
{

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex($id)
    {
      $id = str_replace('poem_', '', $id);
      $model = Poem::find()
        ->with(['user', 'poemTags'])
        ->where(['poem.id' => $id])->one();
      if(!is_object($model)) {
        throw new NotFoundHttpException();
      }

      return $this->render('index', [
        'model' => $model,
      ]);
    }

    public function actionAddLike()
    {
      Yii::$app->response->format = Response::FORMAT_JSON;
      if (Yii::$app->getUser()->isGuest) {
        return ['status' => false, 'redirectTo' => '/' . Yii::$app->getUser()->loginUrl];
      }
      if(isset($_GET['id'])) {
        $poemId = htmlspecialchars(trim($_GET['id']));
        $userId = Yii::$app->getUser()->getId();
        $ch = PoemLike::find()->where(['poemId' => $poemId])
          ->andWhere(['userId' => $userId])->one();
        if(!is_object($ch)) {
          $pl = new PoemLike();
          $pl->poemId = $poemId;
          $pl->userId = $userId;
          $pl->save();
        } else {
          $ch->delete();
        }
        return ['status' => true];
      }
      return ['status' => false];
    }

    public function actionBookmark()
    {
      Yii::$app->response->format = Response::FORMAT_JSON;
      if (Yii::$app->getUser()->isGuest) {
        return ['status' => false, 'redirectTo' => '/' . Yii::$app->getUser()->loginUrl];
      }
      if(isset($_GET['id'])) {
        $poemId = htmlspecialchars(trim($_GET['id']));
        $userId = Yii::$app->getUser()->getId();
        $ch = Bookmark::find()->where(['poemId' => $poemId])
          ->andWhere(['userId' => $userId])->one();
        if(!is_object($ch)) {
          $pl = new Bookmark();
          $pl->poemId = $poemId;
          $pl->userId = $userId;
          $pl->save();
        } else {
          $ch->delete();
        }
        return ['status' => true];
      }
      return ['status' => false];
    }

    public function actionAddComment()
    {
      if (Yii::$app->getUser()->isGuest) {
        return $this->redirect(['/' . Yii::$app->getUser()->loginUrl]);
      }
      if(isset($_GET['id']) AND isset($_GET['text'])) {
        $poemId = htmlspecialchars(trim($_GET['id']));
        $text = htmlspecialchars(trim($_GET['text']));
        $userId = Yii::$app->getUser()->getId();

          $pc = new PoemComment();
          $pc->poemId = $poemId;
          $pc->userId = $userId;
          $pc->text = $text;
          $pc->save();
      }
      return $this->redirect(['poem/poem_' . $poemId . '#comments']);
    }

    public function actionDeleteComment($id)
    {
      if (Yii::$app->getUser()->isGuest) {
        return $this->redirect(['/' . Yii::$app->getUser()->loginUrl]);
      }
      $model = PoemComment::find()
        ->where(['id' => $id])
        ->andWhere(['userId' => Yii::$app->getUser()->getId()])->one();
      if(!is_object($model)) {
        throw new NotFoundHttpException();
      }
      $poemId = $model->poemId;
      $model->delete();
      return $this->redirect(['poem/poem_' . $poemId . '#comments']);

    }

    public function actionDelete($id)
    {
      if (Yii::$app->getUser()->isGuest) {
        return $this->redirect(['/' . Yii::$app->getUser()->loginUrl]);
      }
      $model = Poem::find()
        ->where(['id' => $id])
        ->andWhere(['userId' => Yii::$app->getUser()->getId()])->one();
      if(!is_object($model)) {
        throw new NotFoundHttpException();
      }
      $model->delete();
      return $this->redirect(['/profile']);

    }
}
