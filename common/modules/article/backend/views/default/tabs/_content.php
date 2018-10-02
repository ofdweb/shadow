<?php

use common\widgets\ActiveForm;
use common\widgets\uploader\FileUploaderThumb;
use common\widgets\Redactor;
use modules\tag\widgets\TagSelect2Widget;

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
  
    <?= $form->field($model, 'image[]')->widget(FileUploaderThumb::className(), [
      'files' => $model->images
    ]) ?>
      
    <?= $form->field($model, 'description')->widget(Redactor::className()) ?>
  
    <?= $form->field($model, 'tags')->widget(TagSelect2Widget::classname()) ?>
</div>
