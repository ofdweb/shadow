<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
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

<div class="main-form">
    <?= $form->field($model, 'title')->textInput() ?>
    
    <?= $form->field($model, 'type')->hiddenInput(['value' => $model::TYPE_OPTION_PRODUCT])->label(false) ?>
    
    <?= $form->field($model, 'image[]')->widget(FileUploaderForm::className(), [
      'files' => $model->mainImage
    ]) ?>
</div>
