<?php

/* @var $this yii\web\View */
/* @var $model user\backend\models\User */

$this->title = Yii::t('app', 'Добавить пользователя');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Пользователи'), 'url' => ['index']];
?>

<?= $this->render('_form', compact('model')) ?>
