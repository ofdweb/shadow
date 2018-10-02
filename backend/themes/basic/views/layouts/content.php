<?php
//use dmstr\widgets\Alert;
use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use backend\widgets\ContextualMenuWidget;

$contextualMenu = new ContextualMenuWidget();

?>

<div id="content-wrapper" class="content-wrapper">
    <section class="content-header">
      <h1><?= Html::encode($this->title) ?></h1>
      <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
      ]) ?>
    </section>

    <section class="content">
      <div class="row">
        <?php if ($contextualMenu->canVisible): ?>
          <div class="col-md-2">
            <?= $contextualMenu->run() ?>
          </div>
        <?php endif; ?>
      <div class="<?= $contextualMenu->canVisible ? 'col-md-10' : 'col-md-12' ?>">
        <?= $content ?>
      </div>
     </div>
    </section>
</div>

<footer class="main-footer">
    <?= Yii::$app->settings->get('system', 'app_name', Yii::$app->name) ?>
</footer>

<!-- Add the sidebar's background. This div must be placed
     immediately after the control sidebar -->
<div class='control-sidebar-bg'></div>