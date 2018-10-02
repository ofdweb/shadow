<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model user\backend\models\User */
/* @var $form yii\widgets\ActiveForm */

$fieldOptions = [
    'labelOptions' => ['class' => 'col-sm-2 control-label'],
    'template' => '{label}<div class="col-sm-10">{input}{error}</div>'
];
?>

<div class="user-form">
    <?php $form = ActiveForm::begin([
        'enableAjaxValidation' => true,
        'options' => ['class' => 'form-horizontal', 'data-pjax' => true]
    ]); ?>
    <div class="row">
        <div class="col-md-9">
            <?= $form->field($model->user, 'username', $fieldOptions)->textInput() ?>
            
            <?= $form->field($model->user, 'email', $fieldOptions)->textInput() ?>
            
            <?= $form->field($model, 'password', $fieldOptions)->passwordInput() ?>
            
            <?= $form->field($model->profile, 'surname', $fieldOptions)->textInput() ?>
            
            <?= $form->field($model->profile, 'firstname', $fieldOptions)->textInput() ?>
            
            <?= $form->field($model->profile, 'lastname', $fieldOptions)->textInput() ?>
            
            <?= $form->field($model->profile, 'note', $fieldOptions)->textArea() ?>
            
            <?= $form->field($model->user, 'status_id', $fieldOptions)->dropDownList($model::statusList()) ?>
        </div>
        <div class="col-md-3">
            <img class="profile-user-img img-responsive img-circle" src="../../dist/img/user4-128x128.jpg" alt="User profile picture">
        </div>
      </div>
  
      <div class="box-footer">
          <?= Html::saveButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success btn-flat']) ?>
      </div>
    <?php ActiveForm::end(); ?>
</div>
