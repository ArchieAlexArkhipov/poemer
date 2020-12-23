<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use common\models\Project;

/**
 * @var yii\web\View $this
 * @var common\models\Project $model
 * @var yii\widgets\ActiveForm $form
 */

?>

<?php $form = ActiveForm::begin([
        'id' => 'Author',
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
      <h3 class="box-title">Проект</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
      </div>
    </div>


    <div class="box-body">
      <div class="col-sm-8">
          <?php echo $form->errorSummary($model); ?>

          <?= $form->field($model, 'title')->textInput(['maxlength' => 64]) ?>
          <?= $form->field($model, 'active')->checkbox() ?>

          <?= $form->field($model, 'rightOfAccess')->dropDownList(Project::accessTypes()) ?>

          <?= $form->field($model, 'accessForUnreg')->checkbox() ?>
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
