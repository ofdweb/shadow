<?php

use yii\helpers\Html;
use common\widgets\ActiveForm;
use common\widgets\uploader\FileUploaderForm;

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
    <div class="col-md-9">
        <?= $form->field($model->profile, 'surname')->textInput() ?>
                
        <?= $form->field($model->profile, 'firstname')->textInput() ?>
                
        <?= $form->field($model->profile, 'lastname')->textInput() ?>
                
        <?= $form->field($model->profile, 'note')->textArea() ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model->profile, 'image[]')->widget(FileUploaderForm::className(), [
              'files' => $model->profile->avatar,
        ]) ?>
    </div>
</div>

