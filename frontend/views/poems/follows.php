<?php
use yii\widgets\ListView;

/* @var $this yii\web\View */

$this->title = 'Подписки ·|· Poemer';
?>
<div class="poems-follows">

  <div class="feed-content">

    <h2>Подписки</h2>

    <?=
      ListView::widget([
          'dataProvider' => $dataProvider,
          'itemView' => '../site/_poem',
          'emptyText' => 'Ничего не найдено ;('
      ]);
    ?>



  </div>

</div>
