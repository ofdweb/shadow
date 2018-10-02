<?php

use yii\helpers\Html;
use common\widgets\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model modules\page\models\Page */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Главное меню'), 'url' => ['index']];
?>

<?= DetailView::widget([
    'model' => $model,
    'formatter' => [
        'class' => 'common\widgets\detail\DetailFormatter'
    ],
    'attributes' => [
        'id',
        'title',
        'slug',
        'status_id:status',
        'created_at:datetime',
        'updated_at:datetime',
        [
            'attribute' => 'created_by',
            'value' => function($data) { return $data->created->username; }
        ], [
            'attribute' => 'updated_by',
            'value' => function($data) { return $data->updated->username; }
        ], [
            'attribute' => 'entity_id',
            'format' => 'raw',
            'value' => function($data) { 
              return !$data->linkObject ? null :
                Html::a($data->linkObject->title, ['/' . strtolower($data->entity) . '/default/view', 'id' => $data->entity_id], ['target' => '_blank']); 
            }
        ],
    ],
]) ?>