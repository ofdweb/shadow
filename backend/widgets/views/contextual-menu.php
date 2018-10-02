<?php

use yii\bootstrap\Nav;
use yii\helpers\Html;

?>

<div class="box box-default">
    <?php if ($label): ?>
        <div class="box-header with-border">
            <h3 class="box-title"><?= Yii::t('app', $label) ?></h3>
        </div>
    <?php endif; ?>
    <div class="box-body no-padding">
        <?= Nav::widget([
            'items' => $items,
            'encodeLabels' => false,
            'options' => ['class' =>'nav-pills nav-stacked'],
        ]); ?>  
    </div>
</div>