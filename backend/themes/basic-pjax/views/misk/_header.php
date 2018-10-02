<?php

use yii\helpers\Html;

?>

<div class="box box-solid">
    <div class="box-body">
        <div class="col-md-6">
          <h4><?= Html::fa('user') ?> <?= Html::encode($this->title) ?></h4>
        </div>
        <div class="col-md-6 text-right">
          <div class="btn-group">
            <?= $this->render('@app/views/misk/_menu', ['model' => $model]) ?>
          </div>
        </div>
    </div>
</div>
