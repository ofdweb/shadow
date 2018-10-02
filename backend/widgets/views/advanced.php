<?php

use yii\helpers\Html;
use yii\bootstrap\Collapse;
use common\widgets\ActiveForm;

$form = new ActiveForm();

$boxItems = [];
$collapseItems = [];

foreach ($items as $key => $el) {
  if ($el->type == $el::TYPE_COLLAPSE) {
    $collapseItems[] = [
      'label' => Html::fa($el->icon) . $el->label(),
      'content' => $this->render($el->viewPath(), compact('form', 'model')),
      'contentOptions' => ['class' => $el->isCollapsed($key, $model) ? 'in' : null]
    ];
  } elseif ($el->type == $el::TYPE_BOX) {
    $boxItems[] = $this->render($el->viewPath(), compact('form', 'model'));
  }
}
?>

<div id="edit-advanced" class="box row">
  <?php if ($boxItems): ?>
    <?= implode("\n", $boxItems) ?>
  <?php endif; ?>
  
  <?= Collapse::widget([
    'encodeLabels' => false,
    'options' => ['class' => 'collapse visible-lg-block'],
    'items' => $collapseItems
  ]); ?>  
</div>