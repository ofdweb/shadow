<?php

use common\widgets\ActiveForm;
use yii\helpers\Html;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;

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
    <?= GridView::widget([
        'dataProvider' => new ArrayDataProvider([
            'allModels' => $model->formModel->tokens()
        ]),
        'columns' => [
            'attribute:raw:' . Yii::t('app', 'Токен'),
            'label:raw:' . Yii::t('app', 'Название')
        ],
    ]) ?>
    
    <small><?= Yii::t('app', 'Для вставки токена используйте шаблон вида {token_name}') ?></small>
</div>
