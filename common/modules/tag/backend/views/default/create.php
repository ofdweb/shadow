<?php

/* @var $this yii\web\View */
/* @var $model modules\page\models\Page */

$this->title = Yii::t('app', 'Добавить тег');

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Теги'), 'url' => ['index']];
?>

<?= $this->render('_form', compact('model')) ?>