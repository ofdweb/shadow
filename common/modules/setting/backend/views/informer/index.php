<?php

use yii\helpers\Html;
use backend\widgets\AdvancedWidget;
use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $model modules\page\models\Page */
$this->title = Yii::t('app', 'Системные настройки');
?>

<div class="row">
    <div class="col-md-12">
        <div class="nav-tabs-custom">
            <?= Tabs::widget([
                'items' => [
                    [
                        'label' => Yii::t('app', 'Счетчики'),
                        'content' => $this->render('tabs/_counter', compact('model')),
                    ], [
                        'label' => Yii::t('app', 'Виджеты и чаты'),
                        'content' => $this->render('tabs/_widgets', compact('model')),
                    ]
                 ],
            ]); ?>

            <div class="box-footer">
                <?= Html::saveButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success btn-flat']) ?>
            </div>
        </div>
    </div>
</div>