<?php

use common\widgets\ActiveForm;
use yii\helpers\Html;
use backend\widgets\AdvancedWidget;
use common\widgets\redactor\RedactorLite;

/* @var $this yii\web\View */
/* @var $model modules\article\models\Article */
/* @var $form yii\widgets\ActiveForm */

$form = new ActiveForm();

?>

<div class="row">
    <div class="col-md-8">
        <div class="box box-solid">
          <div class="box-body no-padding">
            <?= $form->errorSummary($model, ['class' => 'alert alert-danger alert-dismissible']); ?>
          </div>
        </div>

        <div class="main-form">
            <?= $form->field($model, 'subject')->textInput() ?>

            <?= $form->field($model, 'body')->widget(RedactorLite::className()) ?>
        </div>
    </div>
    <div class="col-md-4">
        <?= AdvancedWidget::widget([
            'model' => $model,
            'except' => [['core', 'InfoAdvanced'], ['core', 'AuthorAdvanced']],
            'append' => [['webform', 'WebformFromAdvanced'], ['webform', 'WebformToAdvanced']]
        ]); ?>
    </div>
</div>
