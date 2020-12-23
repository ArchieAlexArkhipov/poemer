<?php
use yii\widgets\ListView;

/* @var $this yii\web\View */

$this->title = 'Лучшие стихи ·|· Poemer';
?>
<div class="poems-best">

  <div class="feed-content">

    <h2>Лучшее</h2>

    <?=
      ListView::widget([
          'dataProvider' => $dataProvider,
          'itemView' => '../site/_poem',
          'emptyText' => 'Ничего не найдено ;('
      ]);
    ?>



  </div>

</div>
