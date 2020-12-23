<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var common\models\Category $model
* @var common\models\Project $project
*/

$this->title = 'Новая категория';
$this->params['menuItem'] = 'all-projects';
$this->params['breadcrumbs'][] = ['label' => 'Проект ' . $project->title, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="action-create category-create">

    <p class="pull-left">
        <?= Html::a('Назад', '/admin/project' . '?id=' . $project->id, ['class' => 'btn btn-default']) ?>
    </p>
    <div class="clearfix"></div>

    <?= $this->render('_form', [
      'model' => $model,
      'project' => $project,
    ]); ?>

</div>
