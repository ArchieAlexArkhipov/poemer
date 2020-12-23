<?php
use yii\widgets\ListView;

/* @var $this yii\web\View */

$this->title = 'My Poem';
?>
<div class="poem-index">
  <div>
    <div class="feed-content">


      <?= $this->render('../site/_poem.php', [
          'model' => $model,
          'isPoemPage' => true,
        ]); ?>

        <script src="https://yastatic.net/share2/share.js"></script>
        <div class="ya-share2" style="text-align:right;margin-top:16px;" data-curtain data-services="messenger,vkontakte,facebook,odnoklassniki,telegram,twitter,viber,whatsapp,moimir,skype,evernote,reddit"></div>

        <hr>

        <div class="comment-wrap">
          <h4>Комментарии</h4>


          <?php if (!\Yii::$app->getUser()->isGuest): ?>
            <form id="commentForm" action="/poem/add-comment" method="get">
              <input type="hidden" name="id" value="<?= $model->id ?>">
              <textarea name="text" rows="2" class="comment-textarea" placeholder="Ваш комментарий" required></textarea>
              <button class="comment-btn button-primary">Отправить</button>
              <div class="clearfix"></div>
            </form>
          <?php endif ?>

          <div class="comments" id="comments">

            <?php if ($model->commentsCount < 1): ?>
              <div class="no-comments">Здесь пока нет комментариев</div>
            <?php else: ?>
              <?php foreach ($model->comments as $comment): ?>
                <?= $this->render('_comment', ['model' => $comment]) ?>
              <?php endforeach; ?>
            <?php endif; ?>

          </div>

        </div>

    </div>
  </div>


</div>
