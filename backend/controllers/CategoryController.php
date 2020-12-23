<?php

namespace backend\controllers;

use common\models\Project;
use common\models\Category;
use common\models\search\BugSearch;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\HttpException;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends BaseController
{
    /**
     * @var boolean whether to enable CSRF validation for the actions in this controller.
     * CSRF validation is enabled only when both this property and [[Request::enableCsrfValidation]] are true.
     */
    public $enableCsrfValidation = false;
    public $baseUrl = '/admin/category';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create', 'update', 'delete'],
                        'roles' => ['admin']
                    ], [
                        'allow' => true,
                        'actions' => ['index', 'view'],
                        'roles' => ['admin', 'user']
                    ]
                ]
            ]
        ];
    }



    /**
     * Lists of all bugs for Category model.
     * @return mixed
     */
    public function actionIndex($id)
    {
      $model = $this->findModel($id);
      $searchModel = new BugSearch;
      $dataProvider = $searchModel->search($id, $_GET);

      return $this->render(
          'index',
          [
              'model' => $model,
              'dataProvider' => $dataProvider,
              'searchModel' => $searchModel,
          ]
      );
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws HttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new HttpException(404, 'The requested page does not exist.');
        }
    }

    /**
     * Creates a new Project model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($for)
    {
        $project = Project::findOne($for);
        if(!is_object($project)) {

        }
        $model = new Category;
        $model->projectId = $for;

        try {

          if(\Yii::$app->request->isPost) {
            if ($model->load($_POST) && $model->save()) {
                return $this->redirect('/admin/project?id=' . $for);
            }
          } else {
            $model->load($_GET);
          }

        } catch (\Exception $e) {
            $msg = (isset($e->errorInfo[ 2 ])) ? $e->errorInfo[ 2 ] : $e->getMessage();
            $model->addError('_exception', $msg);
        }
        return $this->render('create', ['model' => $model, 'project' => $project]);
    }


    /**
     * Updates an existing Project model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load($_POST) && $model->save()) {
          return $this->redirect(['/project', 'id' => $model->projectId]);
        } else {
            return $this->render(
                'update',
                [
                    'model' => $model,
                ]
            );
        }
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $projectId = false;
        try {
            $model = $this->findModel($id);
            $projectId = $model->projectId;
            $model->delete();
        } catch (\Exception $e) {
            $msg = (isset($e->errorInfo[ 2 ])) ? $e->errorInfo[ 2 ] : $e->getMessage();
            \Yii::$app->getSession()->setFlash('error', $msg);
            return $this->redirect($this->baseUrl);
        }

        if($projectId) {
          return $this->redirect(['/project', 'id' => $projectId]);
        }
        return $this->redirect(['index']);
    }

    public function actionView($id)
    {
      return $this->redirect($this->baseUrl . '?id=' . $id);
    }
}
