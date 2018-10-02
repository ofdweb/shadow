<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model modules\page\models\Page */

$this->title = Yii::t('app', 'Создать ссылку');

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Главное меню'), 'url' => ['index']];
?>

<?= $this->render('_form', compact('model')) ?>