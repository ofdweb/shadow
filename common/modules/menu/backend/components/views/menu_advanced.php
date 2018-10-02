<?php

use kartik\select2\Select2;
use yii\helpers\Html;

$collapseId = Html::getInputId($model->menu, 'title') . '__box-metatag';
?>

<?= $form->field($model->menu, 'create_link')->checkbox()->label($model->menu->getAttributeLabel('create_link'), [
  'data' => [
    'toggle' => 'collapse',
    'target' => '#' . $collapseId,
  ]
]) ?>

<div id="<?= $collapseId ?>" class="panel-collapse collapse <?= $model->menu->create_link ? 'in' : null ?>">
    <?= $form->field($model->menu, 'title')
          ->hint(Yii::t('app', 'Название ссылки меню (по умолчанию берется заголовок страницы)')) 
    ?>

    <?= $form->field($model->menu, 'parent_id')->widget(Select2::classname(), [
        'data' => $model->menu->dropDownList()
    ]) ?>
</div>