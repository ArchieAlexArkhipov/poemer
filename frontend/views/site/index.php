<?php
use yii\widgets\ListView;

/* @var $this yii\web\View */

$this->title = 'Стихи ·|· Poemer';
?>
<div class="site-index">

  <div class="feed-content">

    <h2>Последние стихи</h2>

    <?=
      ListView::widget([
          'dataProvider' => $dataProvider,
          'itemView' => '_poem',
          'emptyText' => 'Ничего не найдено ;('
      ]);
    ?>



  </div>

</div>
