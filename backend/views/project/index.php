<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use common\models\Project;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\search\ProjectSearch $searchModel
 */

$this->title = \Yii::t('app', 'Все проекты');
$this->params['menuItem'] = 'all-projects';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="action-index project-index">

    <div class="clearfix">
        <p class="pull-left">
            <?= Html::a('<i class="fa fa-plus"></i> ' . 'Новый проект', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

    </div>


    <div class="box">

        <div class="box-body">
          <div class="table-responsive">
              <?= GridView::widget([
                  'layout' => '{summary}{pager}{items}{pager}',
                  'dataProvider' => $dataProvider,
                  'pager' => [
                      'class' => yii\widgets\LinkPager::className(),
                      'firstPageLabel' => Yii::t('app', 'First'),
                      'lastPageLabel' => Yii::t('app', 'Last')],
                  'filterModel' => $searchModel,
                  'columns' => [

                      'id',
                      'title',
                      [
                          'label' => 'Ссылка',
                          'value' => function($model){
                              return $model->link;
                          }
                      ],
                      [
                          'attribute' => 'active',
                          'value' => function($model){
                              return ($model->active) ? 'Да' : 'Нет';
                          }
                      ],
                      [
                          'attribute' => 'rightOfAccess',
                          'value' => function($model){
                              return Project::accessTypes()[ $model->rightOfAccess ];
                          }
                      ],
                      [
                          'attribute' => 'accessForUnreg',
                          'value' => function($model){
                              return ($model->accessForUnreg) ? 'Да' : 'Нет';
                          }
                      ],
                      'created',
                      [
                          'class' => 'yii\grid\ActionColumn',
                          'urlCreator' => function ($action, $model, $key, $index) {
                              // using the column name as key, not mapping to 'id' like the standard generator
                              $params = is_array($key) ? $key : [$model->primaryKey()[0] => (string)$key];
                              $params[0] = \Yii::$app->controller->id ? \Yii::$app->controller->id . '/' . $action : $action;
                              return Url::toRoute($params);
                          },
                          'buttons' => [
                              'view' => function ($url, $model) {
                                  return Html::a('<i class="fa fa-eye"></i>', $url, [
                                      'class' => 'btn btn-info',
                                      'title' => 'Просмотр',
                                      'aria-label' => 'Просмотр',
                                      'data-pjax' => 0,
                                  ]);
                              },
                              'update' => function ($url, $model) {
                                  return Html::a('<i class="fa fa-pencil"></i>', $url, [
                                      'class' => 'btn btn-success',
                                      'title' => 'Редактировать',
                                      'aria-label' => 'Редактировать',
                                      'data-pjax' => 0,
                                  ]);
                              },
                              'delete' => function ($url, $model) {
                                  return Html::a('<i class="fa fa-trash"></i>', $url, [
                                      'class' => 'btn btn-danger',
                                      'title' => 'Удалить',
                                      'aria-label' => 'Удалить',
                                      'data-method' => 'post',
                                      'data-pjax' => 0,
                                      'data-confirm' => 'Вы уверены, что хотите удалить этот элемент?'
                                  ]);
                              },
                          ],
                          'template' => '<div class="btn-group">{view} {update} {delete}</div>',
                          'contentOptions' => ['nowrap' => 'nowrap']
                      ],],
              ]); ?>
          </div>
        </div>

    </div>


</div>
