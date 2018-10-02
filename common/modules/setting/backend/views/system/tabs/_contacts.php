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

<div class="main-form">
    <?= $form->field($model, 'app_phone')->textInput() ?>
                
    <?= $form->field($model, 'app_whatsapp')->textInput() ?>
    
    <?= $form->field($model, 'app_address')->textArea(['rows' => 2]) ?>
    
    <?= $form->field($model, 'app_worktime')->textInput() ?>
    
    <?= $form->field($model, 'app_yamap')->hint(Yii::t('app', 'Координаты объекта через запятую Яндекс.Карт')) ?>
    
    
</div>
