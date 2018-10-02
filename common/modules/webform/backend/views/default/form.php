<?php

use yii\helpers\Html;
use backend\widgets\AdvancedWidget;
use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $model modules\page\models\Page */
$this->title = Yii::t('app', $model->title);
?>

<div class="row">
    <div class="col-md-12">
        <div class="nav-tabs-custom">
            <?= Tabs::widget([
                'items' => [
                    [
                        'label' => Yii::t('app', 'Настройки'),
                        'content' => $this->render('tabs/_setting', compact('model')),
                    ], [
                        'label' => Yii::t('app', 'Токены'),
                        'content' => $this->render('tabs/_token', compact('model')),
                    ],
                 ],
            ]); ?>

            <div class="box-footer">
                <?= Html::saveButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success btn-flat']) ?>
            </div>
        </div>
    </div>
</div>