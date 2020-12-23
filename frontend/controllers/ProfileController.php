<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\web\Response;
use yii\data\ActiveDataProvider;
use common\models\User;
use common\models\Poem;
use common\models\Follow;
use yii\filters\VerbFilter;
use frontend\models\ProfileEditForm;
use yii\web\UploadedFile;
/**
 * Profile controller
 */
class ProfileController extends Controller
{

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex($id = 0)
    {
      if ($id == 0 AND Yii::$app->getUser()->isGuest) {
        return $this->redirect(['/' . Yii::$app->getUser()->loginUrl]);
      }
      $isProfilePage = false;
      if($id == 0) {
        $model = Yii::$app->user->identity;
        $isProfilePage = true;
      } else {
        $model = User::findOne($id);
      }
      if(!is_object($model)) {
        throw new NotFoundHttpException();
      }

      $query = Poem::find()
        ->where(['poem.userId' => $model->id])
        ->orderBy('created DESC');


      $dataProvider = new ActiveDataProvider([
        'query' => $query,
        'pagination' => [
          'pageSize' => 30,
        ],
      ]);

      return $this->render('index', [
        'model' => $model,
        'isProfilePage' => $isProfilePage,
        'dataProvider' => $dataProvider,
      ]);
    }

    public function actionEdit()
    {
      if (Yii::$app->getUser()->isGuest) {
        return $this->redirect(['/' . Yii::$app->getUser()->loginUrl]);
      }
      $model = Yii::$app->user->identity;
      $errorMsg = '';

      if(Yii::$app->request->isPost) {
        // test($_POST);die;

        $model->imageFile = UploadedFile::getInstance($model, 'image');
        $model->upload();

        $model->name = $_POST['User']['name'];
        $model->surname = $_POST['User']['surname'];
        $model->about = $_POST['User']['about'];

        if($model->validate() AND $model->save()) {
          return $this->redirect(['/profile']);
        } else {
          // test($model->errors);die;
          $errorMsg = 'Что-то пошло не так!';
        }
      }

      return $this->render('edit', ['model' => $model, 'errorMsg' => $errorMsg]);
    }

    public function actionFollow($id)
    {
      Yii::$app->response->format = Response::FORMAT_JSON;
      if (Yii::$app->getUser()->isGuest) {
        return ['status' => false, 'redirectTo' => '/' . Yii::$app->getUser()->loginUrl];
      }

      $userId = Yii::$app->getUser()->getId();
      $authorId = $id;

      if($userId != $authorId) {
        $model = Follow::find()
          ->where(['authorId' => $authorId])
          ->andWhere(['userId' => $userId])->one();
        if(is_object($model)) {
          $model->delete();
        } else {
          $model = new Follow();
          $model->userId = $userId;
          $model->authorId = $authorId;
          $model->save();
        }
        return ['status' => true];
      }
      return ['status' => false];
    }

    public function actionGetFollows()
    {
      // if (Yii::$app->getUser()->isGuest) {
      //   return $this->redirect(['/' . Yii::$app->getUser()->loginUrl]);
      // }
      Yii::$app->response->format = Response::FORMAT_JSON;

      if(isset($_GET['id'])) {
        $data = User::find()
          // ->select(['user.id', 'user.name', 'user.surname', 'user.image'])
          ->innerJoin('follow', 'follow.authorId = user.id')
          ->where(['follow.userId' => $_GET['id']])
          ->all();

        $content = $this->renderPartial('_follows-list', ['data' => $data]);

        return ['status' => true, 'content' => $content];

      }

      return ['status' => false];
    }

    public function actionGetFollowers()
    {
      // if (Yii::$app->getUser()->isGuest) {
      //   return $this->redirect(['/' . Yii::$app->getUser()->loginUrl]);
      // }
      Yii::$app->response->format = Response::FORMAT_JSON;

      if(isset($_GET['id'])) {
        $data = User::find()
          // ->select(['user.id', 'user.name', 'user.surname', 'user.image'])
          ->innerJoin('follow', 'follow.userId = user.id')
          ->where(['follow.authorId' => $_GET['id']])->all();

        $content = $this->renderPartial('_follows-list', ['data' => $data]);

        return ['status' => true, 'content' => $content];

      }

      return ['status' => false];
    }
}
