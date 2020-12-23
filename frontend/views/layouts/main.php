<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Url;

// AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
  <meta charset="<?= Yii::$app->charset ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="/frontend/web/favicon.ico" type="image/png">

  <?php $this->registerCsrfMetaTags() ?>
  <title><?= Html::encode($this->title) ?></title>
  <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<header class="main-header">
  <div class="container">
    <a href="/" class="logo">.poemer</a>
    <div class="header-right">
      <nav class="main-nav">
        <a href="/" class="<?= Url::current() == '/' ? 'active' : '' ?>">Лента</a>
        <a  href="<?= $url = Url::to(['/poems/follows']); ?>" class="<?= Url::current() == '/poems/follows' ? 'active' : '' ?>">Подписки</a>
        <a href="<?= $url = Url::to(['/poems/best']); ?>" class="<?= Url::current() == '/poems/best' ? 'active' : '' ?>">Лучшее</a>
        <a href="<?= $url = Url::to(['/games']); ?>" class="<?= Url::current() == '/games/index' ? 'active' : '' ?>">Игры</a>
        <?php if (\Yii::$app->getUser()->isGuest): ?>
          <a href="/auth/login">Войти</a>
        <?php else: ?>
          <a href="<?= $url = Url::to(['/redactor']); ?>" class="with-ico <?= Url::current() == '/redactor' ? 'active' : '' ?>" title="Новый стих"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
          <a href="<?= $url = Url::to(['/poems/bookmarks']); ?>" class="with-ico <?= Url::current() == '/poems/bookmarks' ? 'active' : '' ?>" title="Закладки"><i class="fa fa-bookmark" aria-hidden="true"></i></a>
          <a href="<?= $url = Url::to(['/profile']); ?>" class="with-ico <?= Url::current() == '/profile/index' ? 'active' : '' ?>" title="Профиль"><i class="fa fa-user-circle-o" aria-hidden="true"></i></a>
        <?php endif; ?>
      </nav>
      <form action="/poems/search" method="get" id="searchForm" class="search-form">
        <input type="text" name="query" placeholder="Поиск" value="<?= isset($_GET['query']) ? $_GET['query'] : '' ?>">
        <button><i class="fa fa-search" aria-hidden="true"></i></button>
      </form>

      <a href="#" id="menuBtn"><i class="fa fa-bars" aria-hidden="true"></i></a>
      <div class="clearfix">

      </div>
    </div>
  </div>
</header>

<div class="mobile-menu">
  <form action="/poems/search" method="get" id="mobileSearchForm" class="search-form">
    <input type="text" name="query" placeholder="Поиск" value="<?= isset($_GET['query']) ? $_GET['query'] : '' ?>">
    <button><i class="fa fa-search" aria-hidden="true"></i></button>
  </form>
  <a href="#" id="closeMenu">✖</a>
  <nav class="mobile-nav">
    <a href="/" class="<?= Url::current() == '/' ? 'active' : '' ?>">Лента</a>
    <a  href="<?= $url = Url::to(['/poems/follows']); ?>" class="<?= Url::current() == '/poems/follows' ? 'active' : '' ?>">Подписки</a>
    <a href="<?= $url = Url::to(['/poems/best']); ?>" class="<?= Url::current() == '/poems/best' ? 'active' : '' ?>">Лучшее</a>
    <a href="<?= $url = Url::to(['/games']); ?>" class="<?= Url::current() == '/games/index' ? 'active' : '' ?>">Игры</a>

    <?php if (\Yii::$app->getUser()->isGuest): ?>
      <a href="/auth/login">Войти</a>
    <?php else: ?>
      <a href="<?= $url = Url::to(['/redactor']); ?>" class="with-ico <?= Url::current() == '/redactor' ? 'active' : '' ?>" title="Новый стих">Новый стих</a>
      <a href="<?= $url = Url::to(['/poems/bookmarks']); ?>" class="with-ico <?= Url::current() == '/poems/bookmarks' ? 'active' : '' ?>" title="Закладки">Закладки</a>
      <a href="<?= $url = Url::to(['/profile']); ?>" class="with-ico <?= Url::current() == '/profile/index' ? 'active' : '' ?>" title="Профиль">Профиль</a>
    <?php endif; ?>
  </nav>
</div>


<hr style="margin-top:0px;padding-top:0px;">

<main role="main" class="container">
  <?= $content ?>
</main>


<hr style="margin-bottom:0px;padding-bottom:0px;">
<footer class="main-footer">
  <div class="container">
    <span class="footer-copyright">Copyright © Poemer 2021, все права защищены</span>
    <div class="footer-social">
      <a href="#" title="Instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a>
      <a href="#" title="Вконтакте"><i class="fa fa-vk" aria-hidden="true"></i></a>
      <a href="#" title="You Tube"><i class="fa fa-youtube" aria-hidden="true"></i></a>
      <a href="#" title="Facebook"><i class="fa fa-facebook-f" aria-hidden="true"></i></a>
    </div>
  </div>
</footer>


<?php $this->endBody() ?>
</body>
<?= Html::jsFile(!YII_ENV_DEV ? '@web/bundle.js?1608649747118' : '@web/bundle.js?v='.time()) ?>

</html>
<?php $this->endPage() ?>
