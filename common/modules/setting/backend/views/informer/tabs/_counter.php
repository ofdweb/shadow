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
        <?= $form->field($model, 'ya_metrik')->hint(Yii::t('app', 'Вставьте код XXXXXX Яндекс.Метрики'))  ?>
                
        <?= $form->field($model, 'ga')->hint(Yii::t('app', 'Вставьте код UA-XXXXX-Y Google Analytics')) ?>
    </div>
</div>
