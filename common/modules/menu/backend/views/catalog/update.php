<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model modules\page\models\Page */

$this->title = Yii::t('app', 'Обновить ссылку {0}', [
    $model->title,
]);

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Каталог товаров'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
?>

<?= $this->render('_form', compact('model')) ?>
