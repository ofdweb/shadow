<?php
use yii\helpers\Html;

?>

<div class="<?= $id ?>-nestable-menu">
    <?= Html::button(Yii::t('app', 'Свернуть все'), [
        'data-action' => 'collapse-all',
        'class' => 'btn btn-default'
    ]); ?>
    <?= Html::button(Yii::t('app', 'Раскрыть все'), [
        'data-action' => 'expand-all',
        'class' => 'btn btn-default',
        'style' => 'display: none'
    ]); ?>
</div>