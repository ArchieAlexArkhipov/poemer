<?php

namespace backend\controllers;

use common\models\Project;
use common\models\Category;
use common\models\search\ProjectSearch;
use common\models\search\CategorySearch;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\HttpException;

/**
 * ProjectController implements the CRUD actions for Project model.
 */
class ProjectController extends BaseController
{
    /**
     * @var boolean whether to enable CSRF validation for the actions in this controller.
     * CSRF validation is enabled only when both this property and [[Request::enableCsrfValidation]] are true.
     */
    public $enableCsrfValidation = false;
    public $baseUrl = '/admin/project';

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
                        'actions' => ['index', 'view', 'project'],
                        'roles' => ['admin', 'user']
                    ]
                ]
            ]
        ];
    }



    /**
     * Lists all Project models.
     * @return mixed
     */
    public function actionIndex($id = false)
    {
      if($id) {
        $model = $this->findModel($id);
        $searchModel = new CategorySearch;
        $dataProvider = $searchModel->search($id, $_GET);

        return $this->render(
            'project',
            [
                'model' => $model,
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
            ]
        );

      } else {
        $searchModel = new ProjectSearch;
        $dataProvider = $searchModel->search($_GET);
        Url::remember();

        return $this->render(
            'index',
            [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
            ]
        );
      }
    }

    /**
     * Finds the Project model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Project the loaded model
     * @throws HttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Project::findOne($id)) !== null) {
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
    public function actionCreate()
    {
        $model = new Project;

        try {

          if(\Yii::$app->request->isPost) {
            $model->key = \Yii::$app->security->generateRandomString(5);
            if ($model->load($_POST) && $model->save()) {
                $model->createDefaultStatuses();
                return $this->redirect($this->baseUrl);
            }
          } else {
            $model->load($_GET);
          }

        } catch (\Exception $e) {
            $msg = (isset($e->errorInfo[ 2 ])) ? $e->errorInfo[ 2 ] : $e->getMessage();
            $model->addError('_exception', $msg);
        }
        return $this->render('create', ['model' => $model]);
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
            return $this->redirect($this->baseUrl);
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
     * Deletes an existing Project model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        try {
            $this->findModel($id)->delete();
        } catch (\Exception $e) {
            $msg = (isset($e->errorInfo[ 2 ])) ? $e->errorInfo[ 2 ] : $e->getMessage();
            \Yii::$app->getSession()->setFlash('error', $msg);
            return $this->redirect($this->baseUrl);
        }

        // TODO: improve detection
        $isPivot = strstr('$id', ',');
        if ($isPivot == true) {
            return $this->redirect($this->baseUrl);
        } elseif (isset(\Yii::$app->session[ '__crudReturnUrl' ]) && \Yii::$app->session[ '__crudReturnUrl' ] != '/') {
            Url::remember(null);
            $url = \Yii::$app->session[ '__crudReturnUrl' ];
            \Yii::$app->session[ '__crudReturnUrl' ] = null;

            return $this->redirect($url);
        } else {
            return $this->redirect(['index']);
        }
    }

    public function actionView($id)
    {
      return $this->redirect(Url::toRoute(['/project', 'id' => $id]));
    }
}
