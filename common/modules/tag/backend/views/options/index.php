<?php

use yii\helpers\Html;
use common\widgets\grid\GridView;

$this->title = Yii::t('app', 'Опции товаров');
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'filters' => [
        ['class' => 'common\widgets\grid\filters\SearchColumn'], 
        ['class' => 'common\widgets\grid\filters\StatusDropdownColumn']
     ],
        'layout' => "{form_filter}<br/>{items}\n{summary}\n{pager}",
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],
            'title',
            ['class' => 'common\widgets\grid\ActionColumn'],
      ],
]); ?>
