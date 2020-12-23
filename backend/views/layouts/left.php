<?php
use common\models\Project;
use yii\helpers\Url;
?>

<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/avatar5.png" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->user->identity->username ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

<?php
$items = [];
$items['all-projects'] = [
  'label' => 'Все проекты',
  'icon' => 'globe',
  'template'=>'
        <a href="{url}">{icon} {label}
            <span class="pull-right-container">
                <small class="label pull-right bg-yellow">'.\common\models\Project::find()->where(['active'=>true])->count().'</small>
            </span>
        </a>
    ',
  'url' => Url::toRoute('/project'),
];

$items[] = ['label' => 'Проекты:', 'options' => ['class' => 'header']];

foreach(Project::find()->where(['active' => true])->all() as $key => $project) {
  $items[] = [
    'label' => $project->title,
    'icon' => 'share',
    'url' => Url::toRoute(['/project', 'id' => $project->id]),
    'template' => '
        <a href="{url}">{icon} {label}
        </a>',
  ];

  foreach ($project->categories as $category) {
    $items[] = [
      'label' => $category->title,
      'icon' => 'circle-o',
      'url' => Url::toRoute(['/category', 'id' => $category->id]),
      'template' => '
        <a href="{url}" style="margin-left:16px;">{icon} {label}
          <span class="pull-right-container">
            <small class="label pull-right bg-red">'.$category->bugsCount.'</small>
          </span>
        </a>',
    ];
  }
}

?>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => $items,
            ]
        ) ?>

    </section>

</aside>
