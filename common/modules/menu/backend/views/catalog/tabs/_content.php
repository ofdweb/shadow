<?php

use common\widgets\ActiveForm;
use kartik\select2\Select2;
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

<div class="main-form">
    <?= $form->field($model, 'title')->textInput() ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'parent_id')->widget(Select2::classname(), [
                'data' => $model->dropDownList()
            ]) ?>
        </div>
    </div>
    
    <?= $form->field($model, 'image[]')->widget(FileUploaderForm::className(), [
      'files' => $model->images
    ]) ?>
</div>
