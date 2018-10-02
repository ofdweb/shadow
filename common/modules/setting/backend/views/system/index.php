<?php

use yii\helpers\Html;
use backend\widgets\AdvancedWidget;
use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $model modules\page\models\Page */
$this->title = Yii::t('app', 'Системные настройки');
?>

<div class="row">
    <div class="col-md-6">
        <div class="nav-tabs-custom">
            <?= Tabs::widget([
                'items' => [
                    [
                        'label' => Yii::t('app', 'Информация о сайте'),
                        'content' => $this->render('tabs/_information', compact('model')),
                    ], [
                        'label' => Yii::t('app', 'Контакты'),
                        'content' => $this->render('tabs/_contacts', compact('model')),
                    ]
                 ],
            ]); ?>

            <div class="box-footer">
                <?= Html::saveButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success btn-flat']) ?>
            </div>
        </div>
    </div>
</div>