<?php

use common\widgets\nestable\TreeNestable;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel user\backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Главное меню');
?>

<?= TreeNestable::widget([
    'modelClass' => $modelClass,
]) ?>