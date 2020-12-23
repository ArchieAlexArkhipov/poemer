<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Редактировать профиль ·|· Poemer';
?>
<div class="profile-edit">
  <div class="feed-content">

    <?php if (!empty($errorMsg)): ?>
      <div class="error-msg">
        <?= $errorMsg ?>
      </div>
    <?php endif; ?>


    <?php $form = ActiveForm::begin([
        'id' => 'profileEditForm',
        'options' => [
            'enctype' => 'multipart/form-data'
        ],
    ]) ?>
    <div class="edit-profile-img-wrap">
      <img src="<?= $model->imageUrl ?>" alt="<?= $model->name ?> <?= $model->surname ?>">
      <?= $form->field($model, 'image')->fileInput()->label('Фотография') ?>
    </div>
      <?= $form->field($model, 'name')->textInput(['placeholder' => 'Имя'])->label('Имя') ?>
      <?= $form->field($model, 'surname')->textInput(['placeholder' => 'Фамилия'])->label('Фамилия') ?>
      <?= $form->field($model, 'about')->textarea(['rows' => 3, 'placeholder' => 'О себе'])->label('О себе') ?>
      <?= Html::submitButton('Сохранить', ['class' => 'button-primary']) ?>
  <?php ActiveForm::end() ?>

  </div>
</div>
