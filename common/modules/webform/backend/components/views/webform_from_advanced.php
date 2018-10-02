<?php

use yii\helpers\Html;

$collapseId = Html::getInputId($model, 'from_name') . '__box-webform-from';
?>

<?= $form->field($model, 'from_system')->checkbox()->label($model->getAttributeLabel('from_system'), [
  'data' => [
    'toggle' => 'collapse',
    'target' => '#' . $collapseId,
  ]
]) ?>

<div id="<?= $collapseId ?>" class="panel-collapse collapse <?= $model->from_system ? null : 'in' ?>">
    <?= $form->field($model, 'from_name')
          ->hint(Yii::t('app', 'От кого будет отправлено письмо (по умолчанию название сайта)')) 
    ?>

    <?= $form->field($model, 'from_email')
          ->hint(Yii::t('app', 'С какого Email адреса будет отправлено письмо (по умолчанию берется системный Email)')) 
    ?>
</div>