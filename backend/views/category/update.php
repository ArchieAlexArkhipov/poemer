<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Category $model
 */

$this->title = 'Редактирование категории ' . $model->title;
$this->params['menuItem'] = 'category';
$this->params['breadcrumbs'][] = ['label' => 'Проект', 'url' => $this->params['baseUrl'] . '?id=' . $model->id];
$this->params['breadcrumbs'][] = 'Редактирование ' . (string)$model->title;
?>
<div class="action-update category-update">

    <p>
      <?= Html::a('Назад', $this->params['baseUrl'] . '?id=' . $model->id, ['class' => 'btn btn-default']) ?>
    </p>

	<?php echo $this->render('_form', [
		'model' => $model,
	]); ?>

</div>
