<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var common\models\Project $model
*/

$this->title = 'Новый проект';
$this->params['menuItem'] = 'all-projects';
$this->params['breadcrumbs'][] = ['label' => 'Все проекты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="action-create project-create">

    <p class="pull-left">
        <?= Html::a('Назад', $this->params['baseUrl'], ['class' => 'btn btn-default']) ?>
    </p>
    <div class="clearfix"></div>

    <?= $this->render('_form', [
      'model' => $model,
    ]); ?>

</div>
