<?php

use yii\helpers\Html;
use common\widgets\grid\GridView;

$this->title = Yii::t('app', 'Результат формы');
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'filters' => [
        ['class' => 'common\widgets\grid\filters\SearchColumn'], 
       // ['class' => 'common\widgets\grid\filters\StatusDropdownColumn']
    ],
    'layout' => "{form_filter}<br/>{items}\n{summary}\n{pager}",
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],
            'result',
           // ['class' => 'common\widgets\grid\StatusDataColumn'], 
            'created_at:date',
            //['class' => 'common\widgets\grid\ActionColumn'],
      ],
]); ?>