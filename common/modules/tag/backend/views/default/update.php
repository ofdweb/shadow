<?php

/* @var $this yii\web\View */
/* @var $model modules\page\models\Page */

$this->title = Yii::t('app', 'Обновить: {0}', $model->title);

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Теги'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
?>

<?= $this->render('_form', compact('model')) ?>
