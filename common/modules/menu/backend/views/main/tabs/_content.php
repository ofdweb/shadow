<?php

use common\widgets\ActiveForm;
use yii\helpers\Html;
use common\widgets\NodeDepDropWidget;
use common\models\Node;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model modules\article\models\Article */
/* @var $form yii\widgets\ActiveForm */

$form = new ActiveForm();

$collapseId = Html::getInputId($model, 'slug') . '__box-object';
?>

<div class="box box-solid">
  <div class="box-body no-padding">
    <?= $form->errorSummary($model, ['class' => 'alert alert-danger alert-dismissible']); ?>
  </div>
</div>

<div class="main-form">
    <?= $form->field($model, 'title')->textInput() ?>
  
    <?= $form->field($model, 'link_object')->checkbox()->label($model->getAttributeLabel('link_object'), [
      'data' => [
        'toggle' => 'collapse',
        'target' => '.' . $collapseId,
      ]
    ]) ?>
  
    <div class="<?= $collapseId ?> panel-collapse collapse <?= $model->link_object ? 'in' : null ?>">
        <?= $form->field($model, 'entity_id')->widget(NodeDepDropWidget::classname(), [
          'entityItems' => Node::menuList(),
        ]); ?>
    </div>
  
    <div class="<?= $collapseId ?> panel-collapse collapse <?= $model->link_object ? null : 'in' ?>">
        <?= $form->field($model, 'slug')->textInput()?>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'parent_id')->widget(Select2::classname(), [
                'data' => $model->dropDownList()
            ]) ?>
        </div>
    </div>
</div>
