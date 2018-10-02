<?php

/* @var $this yii\web\View */
/* @var $model user\backend\models\User */

$this->title = Yii::t('app', 'Обновить: {0}', $model->user->username);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Пользователи'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user->username, 'url' => ['view', 'id' => $model->user->id]];

?>

<?= $this->render('_form', compact('model')) ?>