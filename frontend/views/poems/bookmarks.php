<?php
use yii\widgets\ListView;

/* @var $this yii\web\View */

$this->title = 'Заметки ·|· Poemer';
?>
<div class="poems-bookmarks">

  <div class="feed-content">

    <h2>Закладки</h2>

    <?=
      ListView::widget([
          'dataProvider' => $dataProvider,
          'itemView' => '../site/_poem',
          'emptyText' => 'Ничего не найдено ;('
      ]);
    ?>



  </div>

</div>
