<?php

use common\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model modules\article\models\Article */
/* @var $form yii\widgets\ActiveForm */

$form = new ActiveForm();

?>

<div class="box box-solid">
  <div class="box-body no-padding">
    <?= $form->errorSummary($model, ['class' => 'alert alert-danger alert-dismissible']); ?>
  </div>
</div>

<div class="main-form row">
    <div class="col-md-4">
        <?= $form->field($model, 'chat')->textArea(['rows' => 10]) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'callback')->textArea(['rows' => 10]) ?>
    </div>
</div>
