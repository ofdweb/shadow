<?php

use yii\helpers\Html;
use common\widgets\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model modules\page\models\Page */

$this->title = Yii::t('app', 'Конфигурация сервера');
?>

<?= DetailView::widget([
    'model' => $model,
]) ?>