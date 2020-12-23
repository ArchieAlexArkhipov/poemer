<?php

namespace backend\controllers;

use common\models\Project;
use common\models\Bug;
use common\models\search\BugSearch;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\HttpException;

/**
 * BugController implements the CRUD actions for Bug model.
 */
class BugController extends BaseController
{
    /**
     * @var boolean whether to enable CSRF validation for the actions in this controller.
     * CSRF validation is enabled only when both this property and [[Request::enableCsrfValidation]] are true.
     */
    public $enableCsrfValidation = false;
    public $baseUrl = '/admin/bug';

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
                        'actions' => ['update', 'delete'],
                        'roles' => ['admin']
                    ]
                ]
            ]
        ];
    }


    /**
     * Finds the Bug model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Bug the loaded model
     * @throws HttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Bug::findOne($id)) !== null) {
            return $model;
        } else {
            throw new HttpException(404, 'The requested page does not exist.');
        }
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
          return $this->redirect(['/category', 'id' => $model->categoryId]);
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
     * Deletes an existing Bug model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $categoryId = false;
        try {
            $model = $this->findModel($id);
            $categoryId = $model->categoryId;
            $model->delete();
        } catch (\Exception $e) {
            $msg = (isset($e->errorInfo[ 2 ])) ? $e->errorInfo[ 2 ] : $e->getMessage();
            \Yii::$app->getSession()->setFlash('error', $msg);
            return $this->redirect($this->baseUrl);
        }

        if($categoryId) {
          return $this->redirect(['/category', 'id' => $categoryId]);
        }
        return $this->redirect(['index']);
    }
}
