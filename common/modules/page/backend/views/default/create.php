<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model modules\page\models\Page */

$this->title = Yii::t('app', 'Добавить страницу');

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Страницы'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', compact('model')) ?>