<?php

use yii\helpers\Html;

?>

<li class="fileuploader-item">
  <div class="fileuploader-item-inner">
    <div class="thumbnail-holder">${image}</div>
    <div class="actions-holder">
      <?= Html::a(Html::tag('i'), null, ['class' => 'fileuploader-action fileuploader-action-sort', 'title' => Yii::t('app', 'Сортировка'), 'visible' => $sort]) ?>
      <?= Html::a(Html::tag('i'), null, ['class' => 'fileuploader-action fileuploader-action-remove', 'title' => Yii::t('app', 'Удалить'), 'visible' => true]) ?>
      <!--<span class="fileuploader-action-popup"></span>-->
    </div>
    <div class="progress-holder">${progressBar}</div>
  </div>
</li>