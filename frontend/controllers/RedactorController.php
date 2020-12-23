<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\web\Response;
use \common\models\Tag;
use \common\models\PoemTag;
use \common\models\Poem;
use yii\widgets\ActiveForm;

/**
 * Redactor controller
 */
class RedactorController extends Controller
{

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex($id = 0)
    {
      if (Yii::$app->getUser()->isGuest) {
        return $this->redirect(['/' . Yii::$app->getUser()->loginUrl]);
      }

      if($id > 0) {
        $model = Poem::find()
          ->where(['id' => $id])
          ->andWhere(['userId' => Yii::$app->getUser()->getId()])
          ->one();
        if(!is_object($model)) {
          throw new NotFoundHttpException();
        }
      } else {
        $model = new Poem();
        $model->userId = Yii::$app->getUser()->getId();
      }

      if(Yii::$app->request->isPost) {
        test($_POST);die;
        if(isset($_POST['title']) AND isset($_POST['text'])) {

        }
      }

      return $this->render('index', [
        'user' => Yii::$app->user->identity,
        'model' => $model,
        'isEdit' => ($id > 0) ? true : false,
      ]);
    }

    public function actionValidate()
    {
      $model = new Poem();
      $request = \Yii::$app->getRequest();
      if ($request->isPost && $model->load($request->post())) {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return ActiveForm::validate($model);
      }
    }
    
    public function actionSave()
    {
      $isEdit = false;
      if(isset($_POST['Poem']['id'])) {
        $model = Poem::find()
          ->where(['id' => trim($_POST['Poem']['id'])])
          ->andWhere(['userId' => Yii::$app->getUser()->getId()])
        ->one();
        $isEdit = true;
      } else {
        $model = new Poem();
      }
      $request = \Yii::$app->getRequest();
      if ($request->isPost) {
        if(isset($_POST['Poem']['isAnonymous'])) {
          $_POST['Poem']['isAnonymous'] = ($_POST['Poem']['isAnonymous'] == 'on') ? true : false;
        }
        if(isset($_POST['Poem']['forAdults'])) {
          $_POST['Poem']['forAdults'] = ($_POST['Poem']['forAdults'] == 'on') ? true : false;
        }
        if(isset($_POST['Poem']['isPublished'])) {
          $_POST['Poem']['isPublished'] = ($_POST['Poem']['isPublished'] == 'on') ? true : false;
        }

        // test($_POST);die;

        if($model->load($_POST)) {
          $model->save();

          if($isEdit) {
            $pTags = PoemTag::find()
              ->where(['poemId' => $model->id])
            ->all();
            foreach ($pTags as $pTag) {
              $pTag->delete();
            }
          }

          if(isset($_POST['tags'])) {
            foreach ($_POST['tags'] as $key => $tag) {
              $tp = new PoemTag();
              $tp->poemId = $model->id;
              $tp->tagId = $tag;

              $tp->save(false);
            }
          }

          return $this->redirect(['/profile?' . ($isEdit ? 'e' : 's')]);
        }
      }
      return $this->redirect(['/redactor']);
    }

    public function actionGetTags()
    {
      Yii::$app->response->format = Response::FORMAT_JSON;

      if (!Yii::$app->getUser()->isGuest) {
        if(isset($_GET['search'])) {
          $search = ucfirst(htmlspecialchars(trim($_GET['search'])));
          $tags = Tag::find()->where(['LIKE', 'title', $search])->all();

          $data = [];
          foreach($tags as $key => $tag) {
            $data[] = [
              'id' => $tag->id,
              'title' => $tag->title,
            ];
          }
          if(!empty($data)) {
            return $data;
          }

        }
      }
      return false;
    }

}
