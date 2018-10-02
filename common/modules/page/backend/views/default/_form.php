<?php

use yii\helpers\Html;
use yii\bootstrap\Tabs;
use backend\widgets\AdvancedWidget;

/* @var $this yii\web\View */
/* @var $model modules\page\models\Page */
?>

<div class="row">
    <div class="col-md-8">
        <div class="nav-tabs-custom">
              <?= Tabs::widget([
                'items' => [
                    [
                        'label' => Yii::t('app', 'Содержимое'),
                        'content' => $this->render('tabs/_content', compact('model')),
                    ]
                 ],
              ]); ?>

          <div class="box-footer">
              <?= Html::saveButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success btn-flat']) ?>
          </div>
        </div>
    </div>
    <div class="col-md-4">
        <?= AdvancedWidget::widget([
            'model' => $model,
            'append' => [['metatag', 'MetatagAdvanced'], ['menu', 'MenuAdvanced']]
        ]); ?>
    </div>
</div>
