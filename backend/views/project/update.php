<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Project $model
 */

$this->title = 'Редактирование проекта ' . $model->title;
$this->params['menuItem'] = 'project';
$this->params['breadcrumbs'][] = ['label' => 'Все проекты', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Проект ' . (string)$model->title;
?>
<div class="action-update project-update">

    <p>
      <?= Html::a('Назад', $this->params['baseUrl'], ['class' => 'btn btn-default']) ?>
    </p>

	<?php echo $this->render('_form', [
		'model' => $model,
	]); ?>

</div>
