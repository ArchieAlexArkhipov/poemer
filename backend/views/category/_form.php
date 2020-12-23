<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use common\models\Project;
use common\models\Category;
use yii\helpers\ArrayHelper;

/**
 * @var yii\web\View $this
 * @var common\models\Category $model
 * @var common\models\Project $project
 * @var yii\widgets\ActiveForm $form
 */

?>

<?php $form = ActiveForm::begin([
        'id' => 'CategoryForm',
        'layout' => 'horizontal',
        'enableClientValidation' => false,
        'options' => [
            'enctype' => 'multipart/form-data'
        ]
    ]
);
?>

<div class="box">

    <div class="box-header with-border">
      <h3 class="box-title">Категория проекта <?= $project->title ?? '' ?></h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
      </div>
    </div>


    <div class="box-body">
      <div class="col-sm-8">
          <?php echo $form->errorSummary($model); ?>

          <?php if ($model->isNewRecord): ?>
            <?= $form->field($model, 'projectId')->dropDownList([ $project->id => $project->title ], ['disabled' => true]) ?>
          <?php else: ?>
            <?= $form->field($model, 'projectId')->dropDownList(ArrayHelper::map(Project::find()->all(), 'id', 'title')) ?>
          <?php endif; ?>
          <?= $form->field($model, 'title')->textInput(['maxlength' => 64]) ?>

          <?= $form->field($model, 'color')->dropDownList(Category::colors()) ?>

      </div>
    </div>

    <div class="box-footer">
        <?= Html::submitButton(
             ($model->isNewRecord
                ? 'Создать' : 'Сохранить'),
            [
                'id' => 'save-' . $model->formName(),
                'class' => 'btn btn-success'
            ]
        );
        ?>
    </div>

</div>

<?php ActiveForm::end(); ?>
