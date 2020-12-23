<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use \common\models\Poem;

/**
 * Site controller
 */
class SiteController extends Controller
{

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {

      $query = Poem::find()
        ->where(['poem.isPublished' => true])
        ->orderBy('created DESC');


      $dataProvider = new ActiveDataProvider([
        'query' => $query,
        'pagination' => [
          'pageSize' => 30,
        ],
      ]);


      return $this->render('index', [
        'dataProvider' => $dataProvider,
      ]);
    }
}
