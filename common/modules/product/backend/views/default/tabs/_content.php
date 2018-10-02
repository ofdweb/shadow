<?php

use common\widgets\ActiveForm;
use common\widgets\uploader\FileUploaderForm;
use common\widgets\Redactor;
use yii\helpers\ArrayHelper;
use modules\tag\backend\models\ProductOption;

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
  
    <?= $form->field($model, 'image[]')->widget(FileUploaderForm::className(), [
      'files' => $model->images
    ]) ?>
    
    <?= $form->field($model, 'announcement')->textArea(['rows' => 2]) ?>
      
    <?= $form->field($model, 'description')->widget(Redactor::className()) ?>
  
    <?= $form->field($model, 'tags')->checkboxList(ArrayHelper::map(ProductOption::find()->All(), 'id', 'title')) ?>
</div>
