<?php

use yii\helpers\Html;
use yii\bootstrap\Tabs;
use backend\widgets\AdvancedWidget;

/* @var $this yii\web\View */
/* @var $model modules\page\models\Page */
?>

<div class="row">
    <div class="col-md-12">
        <div class="nav-tabs-custom">
              <?= Tabs::widget([
                'items' => [
                    [
                        'label' => Yii::t('app', 'Аккаунт'),
                        'content' => $this->render('tabs/_edit_account', compact('model')),
                        'active' => $model->hasErrors() ? $model->user->hasErrors() : true
                    ], [
                        'label' => Yii::t('app', 'Профиль'),
                        'content' => $this->render('tabs/_edit_profile', compact('model')),
                        'active' => $model->hasErrors() ? $model->profile->hasErrors() : false
                    ]
                 ],
              ]); ?>

          <div class="box-footer">
              <?= Html::saveButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success btn-flat']) ?>
          </div>
        </div>
    </div>
</div>