<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

?>
<div class="box box-solid">
    <div class="box-body no-padding">
        <?= DetailView::widget([
            'model' => $model->user,
            'attributes' => [
                'profile.surname',
                'profile.firstname',
                'profile.lastname',
                'created_at:datetime',
                'updated_at:datetime',
                'profile.note:text'
            ],
        ]) ?>
    </div>
</div>