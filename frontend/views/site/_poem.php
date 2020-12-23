<?php
use frontend\components\DateFormater;
?>

<div class="poem-card">
  <div class="poem-header">
    <div class="poem-img">
      <div class="img" style="background:url(<?= $model->user->getImageUrl($model->isAnonymous) ?>);background-size: cover;background-position: center;"></div>
    </div>
    <div class="poem-author">
      <?php if(!$model->isAnonymous): ?>
        <a class="poem-author-name" href="/profile/<?= $model->user->id ?>"><?= $model->user->name ?> <?= $model->user->surname ?></a>
      <?php else: ?>
          Анонимно
      <?php endif; ?>
      <div class="poem-date"><?= DateFormater::format($model->created); ?></div>
    </div>
    <div class="poem-actions">
      <a href="#" class="poem-likes-btn <?= ($model->checkLike(\Yii::$app->getUser()->getId())) ? 'active' : '' ?>" title="Мне нравится" data-id="<?= $model->id ?>">
        <i class="fa fa-heart-o" aria-hidden="true"></i>
        <span><?= $model->likesCount ?></span>
      </a>
      <?php if(!isset($isPoemPage)): ?>
      <a href="/poem/poem_<?= $model->id ?>#comments" class="poem-comments-btn" title="К комментариям">
        <i class="fa fa-commenting-o" aria-hidden="true"></i>
        <span><?= $model->commentsCount ?></span>
      </a>
      <?php else: ?>
        <a href="#" class="poem-bookmark-btn <?= ($model->checkBookmark(\Yii::$app->getUser()->getId())) ? 'active' : '' ?>" title="В закладки" data-id="<?= $model->id ?>">
          <i class="fa fa-bookmark" aria-hidden="true"></i>
        </a>
      <?php endif; ?>

    </div>
    <div class="clearfix"></div>


    <?php if ((isset($isProfile) AND $isProfile) OR \Yii::$app->getUser()->getId() == $model->userId): ?>
      <div class="poem-top-actions">
        <a href="/redactor/<?= $model->id ?>" class="button-primary float-left">Редактировать</a>
        <a href="/poem/delete/<?= $model->id ?>" class="button-primary exit-btn float-right" onclick="return confirm('Вы уверены?')">Удалить</a>
        <div class="clearfix"></div>
      </div>
    <?php endif; ?>

  </div>
  <div class="poem-content">
    <?php
      $count = count(explode("<div>", $model->text));
      if($count < 6) {
        $count = count(explode("br", $model->text));
      }
      if($count < 6) {
        $count = count(explode("p", $model->text));
      }
    ?>

    <div class="poem-content-wrap <?= (isset($isPoemPage) OR $count < 6) ? 'open' : '' ?>">
      <div class="poem-title">
        <a href="/poem/poem_<?= $model->id ?>"><?= $model->title ?></a>
      </div>
      <div class="poem-text">
        <span>
          <?= $model->text ?>
        </span>
      </div>
    </div>

    <?php if(!isset($isPoemPage) AND $count >= 6): ?>
      <button class="button-primary open-poem">Раскрыть</button>
    <?php endif; ?>

    <?php if ((isset($isProfile) AND $isProfile) AND !$model->isPublished): ?>
      <div class="no-published-label">Не опубликовано!</div>
    <?php endif; ?>

  </div>
  <div class="poem-footer">

    <div class="poem-tags">
      <?php if (count($model->poemTags) > 0): ?>
        <?php foreach ($model->poemTags as $pt): ?>
          <a href="/poems/tag/<?= $pt->tagId ?>"><?= $pt->tag->title ?></a>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="no-tags-label">Тегов нет</div>
      <?php endif; ?>
    </div>

  </div>

</div>
