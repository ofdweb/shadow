<?php

use yii\helpers\Html;
use common\widgets\grid\GridView;

$this->title = Yii::t('app', 'Пользователи');
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
            'username',
            'email',
            [
                'attribute' => 'role_list',
                'format' => 'raw',
                'value' => function($data) {
                    return Html::itemsGroup($data->roles, 'name', 'span', ' | ');
                  }
            ],
            ['class' => 'common\widgets\grid\StatusDataColumn'], 
            'created_at:date',
            [
                'attribute' => 'profile.last_vizit_at',
                'format' => 'raw',
                'value' => function($data) {
                    return \Yii::$app->formatter->asRelativeTime($data->profile->last_vizit_at);
                  }
            ],
            ['class' => 'common\widgets\grid\ActionColumn'],
      ],
]); ?>