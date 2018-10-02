<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model modules\article\models\Article */

$this->title = Yii::t('app', 'Обновить: {0}', [$model->title]);

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Статьи'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];

?>

<?= $this->render('_form', compact('model')) ?>