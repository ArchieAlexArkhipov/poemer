<?php
use yii\widgets\ListView;

/* @var $this yii\web\View */

$this->title = $model->name . ' ' . $model->surname . ' ·|· Poemer';

$successMsg = false;
if(isset($_GET['s']) OR isset($_GET['e'])) {
  echo '<script>localStorage.clear();</script>';
  $successMsg = 'Стих успешно добавлен!';
  if(isset($_GET['e'])) {
    $successMsg = 'Стих успешно обновлен!';
  }
}
?>
<div class="profile-index">
  <div class="feed-content">

    <div class="profile-card">

      <div class="profile-img">
        <div class="img" style="background:url(<?= $model->imageUrl ?>);background-size: cover;background-position: center;"></div>
      </div>

      <h1 class="profile-name"><?= $model->name ?> <?= $model->surname ?></h1>
      <p class="profile-about"><?= $model->about ?></p>

      <div class="profile-stat">
        <div class="row">
          <div class="col-sm-4">
            <a href="#poems" class="profile-stat-col">
              <div><?= $model->poemsCount; ?></div>
              <span>Стихи</span>
            </a>
          </div>
          <div class="col-sm-4">
            <a href="#" class="profile-stat-col" id="followsBtn" data-user-id="<?= $model->id ?>">
              <div><?= $model->followsCount ?></div>
              <span>Подписки</span>
            </a>
          </div>
          <div class="col-sm-4">
            <a href="#" class="profile-stat-col" id="followersBtn" data-user-id="<?= $model->id ?>">
              <div id="followersCount"><?= $model->followersCount; ?></div>
              <span>Подписчики</span>
            </a>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
      <?php if ($isProfilePage): ?>
        <a href="/profile/edit" class="button-primary profile-action" id="editBtn" title="Перейти к редактированию">Редактировать</a>

        <?php if (!\Yii::$app->getUser()->isGuest): ?>
          <br>
          <a href="/auth/logout" class="button-primary exit-btn">Выйти</a>

        <?php endif; ?>

      <?php else: ?>
        <?php $isFollow = $model->checkFollow(\Yii::$app->getUser()->getId(), $model->id); ?>
        <a href="#" class="button-primary profile-action <?= $isFollow ? 'active' : '' ?>" id="followBtn" data-id="<?= $model->id ?>" title="Подписаться на автора">
          <?php if (\Yii::$app->getUser()->getId() == $model->id): ?>
            Это вы
          <?php else: ?>
            <?php if ($isFollow): ?>
              Вы подписаны
            <?php else: ?>
              Следить
            <?php endif; ?>
          <?php endif; ?>
        </a>
      <?php endif; ?>

    </div>

    <?php if ($successMsg): ?>
      <div class="succes-msg">
        <?= $successMsg ?>
      </div>
    <?php endif; ?>

    <hr>

    <div id="poems"></div>
    <?=
      ListView::widget([
          'dataProvider' => $dataProvider,
          'itemView' => '../site/_poem',
          'emptyText' => 'Ничего не найдено ;(',
          'viewParams' => [
            'isProfile' => true,
          ],
      ]);
    ?>


  </div>
</div>

<div class="modal-wrapper">
  <div class="modal-block">
    <div class="modal-header">
      <span>Подписки</span>
      <a href="#" class="close-modal-btn">✖</a>
    </div>
    <div class="modal-content-wrap">
      <div class="modal-scroll">

      </div>
    </div>
  </div>
</div>
