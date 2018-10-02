<?php

/* @var $this yii\web\View */
/* @var $model modules\article\models\Article */

$this->title = Yii::t('app', 'Добавить товар');

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Товары'), 'url' => ['index']];

?>

<?= $this->render('_form', compact('model')) ?>