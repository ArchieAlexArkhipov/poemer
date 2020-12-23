<?php
use yii\widgets\ListView;

/* @var $this yii\web\View */

$this->title = $searchQuery . ' ·|· Poemer';
?>
<div class="poems-tag">

  <div class="feed-content">

    <h2><?= $searchQuery ?></h2>

    <?=
      ListView::widget([
          'dataProvider' => $dataProvider,
          'itemView' => '../site/_poem',
          'emptyText' => 'Ничего не найдено ;('
      ]);
    ?>



  </div>

</div>
