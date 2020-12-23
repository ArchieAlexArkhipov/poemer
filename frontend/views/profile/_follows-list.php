<div class="follows-modal-list">
  <?php if (count($data) > 0): ?>
    <?php foreach ($data as $key => $follow): ?>

      <div class="fml-block">
        <div class="fml-img">
          <div class="img" style="background:url(<?= $follow->imageUrl ?>);background-size: cover;background-position: center;"></div>
        </div>
        <div class="fml-content">
          <a href="/profile/<?= $follow->id ?>"><?= $follow->name ?> <?= $follow->surname ?></a>
        </div>
        <?php $isFollow = $follow->checkFollow(\Yii::$app->getUser()->getId(), $follow->id); ?>
        <a href="#" class="button-primary fml-follow-btn <?= $isFollow ? 'active' : '' ?>" data-id="<?= $follow->id ?>">

          <?php if (\Yii::$app->getUser()->getId() == $follow->id): ?>
            Это вы
          <?php else: ?>
            <?php if ($isFollow): ?>
              Вы подписаны
            <?php else: ?>
              Следить
            <?php endif; ?>
          <?php endif; ?>
        </a>
        <div class="clearfix"></div>
      </div>

    <?php endforeach; ?>

  <?php else: ?>
    <div class="empty">
      Ничего не найдено ;(
    </div>
  <?php endif; ?>
</div>
