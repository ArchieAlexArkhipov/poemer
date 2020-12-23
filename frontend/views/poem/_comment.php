<?php
use frontend\components\DateFormater;
?>

<div class="comment-block">
  <div class="comment-img">
    <div class="img" style="background:url(<?= $model->user->imageUrl ?>);background-size: cover;background-position: center;"></div>
  </div>
  <div class="comment-content">
    <div class="comment-info">
      <a class="comment-author" href="/profile/<?= $model->user->id ?>">
        <?= $model->user->name ?> <?= $model->user->surname ?>
      </a>
    </div>
    <div class="comment-text">
      <?= $model->text ?>
    </div>
    <div class="comment-date">
      <?= DateFormater::format($model->created); ?>
    </div>
    <?php if (Yii::$app->getUser()->getId() == $model->userId): ?>
      <a href="/poem/delete-comment/<?= $model->id ?>" class="button-primary comment-delete" onclick="return confirm('Вы уверены?')">Удалить</a>
    <?php endif; ?>
  </div>
  <div class="clearfix"></div>
</div>
