<?php

use yii\helpers\Html;

$collapseId = Html::getInputId($model, 'to_email') . '__box-webform-to';
?>

<?= $form->field($model, 'to_system')->checkbox()->label($model->getAttributeLabel('to_system'), [
  'data' => [
    'toggle' => 'collapse',
    'target' => '#' . $collapseId,
  ]
]) ?>

<div id="<?= $collapseId ?>" class="panel-collapse collapse <?= $model->to_system ? null : 'in' ?>">
    <?= $form->field($model, 'to_email')
          ->hint(Yii::t('app', 'Кому будет отправлено письмо (по умолчанию берется системный Email)')) 
    ?>
</div>