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
  <?php $this->registerCsrfMetaTags() ?>
  <title><?= Html::encode($this->title) ?></title>

  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600&family=Comfortaa&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/frontend/web/css/auth.css?v=1.0">

  <?php $this->head() ?>
</head>
<body class="auth-body">
<?php $this->beginBody() ?>

<main role="main" class="container">
  <?= $content ?>
</main>

<?php $this->endBody() ?>
</body>
<?= Html::jsFile(!YII_ENV_DEV ? '@web/bundle.js?1607691512958' : '@web/bundle.js?v='.time()) ?>
</html>
<?php $this->endPage() ?>
