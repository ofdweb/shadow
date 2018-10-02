<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\widgets\ActiveForm;
use backend\widgets\AdvancedWidget;

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
    <div class="col-md-8">
        <?= $form->field($model->user, 'username')->textInput() ?>
                
        <?= $form->field($model->user, 'email')->textInput() ?>
      
        <?php if ($model->isNewUser): ?>
            <?= $form->field($model, 'password')->textInput() ?>
      
            <?= $form->field($model, 'password_repeat')->textInput() ?>
        <?php endif; ?>
      
        <?= $form->field($model, 'roles')->checkboxList(ArrayHelper::map(Yii::$app->authManager->roles, 'name', 'description')) ?>
    </div>
    <div class="col-md-4">
        <?= AdvancedWidget::widget([
            'model' => $model->user,
            'except' => [['core', 'AuthorAdvanced']]
        ]); ?>
    </div>
</div>

