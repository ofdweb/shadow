<?php

use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
//use backend\components\MenuManager;
use backend\widgets\ContextualMenuWidget;

//$moduleItemList = MenuManager::moduleItemList();
//dd(Yii::$app->controller->module);

$widget = new ContextualMenuWidget();
?>

<section class="content-header">
      <h1><?= Html::encode($this->title) ?></h1>
      <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
      ]) ?>
</section>

<section class="content">
  <div class="row">
    <?php if ($widget->canVisible): ?>
      <div class="col-md-2">
        <?= $widget->run() ?>
      </div>
    <?php endif; ?>
  <div class="<?= $widget->canVisible ? 'col-md-10' : 'col-md-12' ?>">