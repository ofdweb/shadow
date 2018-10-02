<?php

/* @var $this yii\web\View */
/* @var $model modules\article\models\Article */

$this->title = Yii::t('app', 'Добавить статью');

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Статьи'), 'url' => ['index']];

?>

<?= $this->render('_form', compact('model')) ?>