<?php
use frontend\components\DateFormater;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */

$this->title = 'Новый стих ·|· Poemer';
?>
<div class="redactor-index">

  <div class="feed-content">

    <?php $form = ActiveForm::begin([
        'id' => 'redactorForm',
        'action' => '/redactor/save',
        'enableAjaxValidation' => true,
        'validationUrl' => '/redactor/validate',
    ]) ?>

      <?php if ($isEdit): ?>
        <?= $form->field($model, 'id', ['template' => '{input}'])->hiddenInput() ?>
      <?php endif; ?>

      <?= $form->field($model, 'userId', ['template' => '{input}'])->hiddenInput() ?>


      <div class="poem-card editor-poem-card">

        <div class="poem-header">
          <div class="poem-img">
            <div class="img" style="background:url(<?= $user->imageUrl ?>);background-size: cover;background-position: center;"></div>
          </div>
          <div class="poem-author">
            <a class="poem-author-name" href="/profile/<?= $user->id ?>"><?= $user->name ?> <?= $user->surname ?></a>
            <div class="poem-date"><?= DateFormater::format(($isEdit) ? $model->created : ''); ?></div>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="poem-content">

          <div class="poem-content-wrap open">
            <div class="poem-title">
              <?= $form->field($model, 'title', ['template' => '{input}{error}'])->textInput(['placeholder' => 'Название', 'class' => 'editor-input']) ?>
            </div>
            <div class="poem-text">

              <?= $this->render('editor', [
                'model' => $model,
                'isEdit' => $isEdit,
              ]); ?>
              <?= $form->field($model, 'text', ['template' => '{input}{error}'])->hiddenInput() ?>

            </div>
          </div>

        </div>
        <div class="poem-footer">

          <div class="poem-tags">
            <?php if ($isEdit): ?>
              <?php foreach ($model->poemTags as $pt): ?>
                <a data-id="<?= $pt->tagId ?>"><?= $pt->tag->title ?><input type="hidden" name="tags[]" value="<?= $pt->tagId ?>" /><span>✖</span></a>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>

          <input type="text" placeholder="Тэг" id="poemTagInput" autocomplete="off">

          <div class="tags-list-wrap">
            <div class="tags-list">
              <span>Выберите нужный тег:</span>
              <div>
              </div>
            </div>
          </div>

        </div>

      </div>

      <div class="site-checkbox">
        <input type="checkbox" id="isAnonymous" name="Poem[isAnonymous]" <?= ($isEdit) ? $model->isAnonymous ? 'checked' : ''  : '' ?> />
        <label for="isAnonymous"><span></span>Анонимное стихотворение</label>
      </div>

      <div class="site-checkbox">
        <input type="checkbox" id="forAdults" name="Poem[forAdults]" <?= ($isEdit) ? $model->forAdults ? 'checked' : ''  : '' ?> />
        <label for="forAdults"><span></span>Для взрослых (18+)</label>
      </div>

      <div class="site-checkbox">
        <input type="checkbox" id="isPublished" name="Poem[isPublished]" <?= ($isEdit) ? $model->isPublished ? 'checked' : '' : '' ?> />
        <label for="isPublished"><span></span>Опубликовать</label>
      </div>


      <div id="error-msg"></div>


      <div class="redactor-btns">
        <?php if ($isEdit): ?>
          <button type="submit" class="button-primary float-left redactor-create-btn">Сохранить</button>
        <?php else: ?>
          <button type="submit" class="button-primary float-left redactor-create-btn">Создать</button>
          <a class="button-filled float-right" id="saveBtn" href="#">Сохранить</a>
        <?php endif; ?>
        <div class="clearfix"></div>
      </div>

    <?php ActiveForm::end() ?>


  </div>


</div>
