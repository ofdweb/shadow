<?php

use yii\helpers\Html;

?>

<ul class="panel-body nav-stacked nav box-comments">
    <?php if ($model->hasProperty('created_at')): ?>
      <li class="box-comment">
        <label class="control-label"><?= Html::fa('clock-o') . $model->getAttributeLabel('created_at') ?>:</label> 
        <?= $model->isNewRecord ? Yii::t('app', 'Не сохранено') : Yii::$app->formatter->asDateTime($model->created_at) ?>
      </li>
      <li class="box-comment">
        <label class="control-label"><?= Html::fa('hourglass-o') . $model->getAttributeLabel('updated_at') ?>:</label> 
        <?= $model->isNewRecord ? Yii::t('app', 'Не сохранено') : Yii::$app->formatter->asDateTime($model->updated_at) ?>
      </li>
    <?php endif; ?>
    <?php if ($model->hasProperty('created_by')): ?>
      <li class="box-comment">
        <label class="control-label"><?= Html::fa('user-o') . $model->getAttributeLabel('created_by') ?>:</label> 
        <?= $model->isNewRecord ? Yii::$app->user->identity->username : $model->created->username ?>
      </li>
    <?php endif; ?>
</ul>