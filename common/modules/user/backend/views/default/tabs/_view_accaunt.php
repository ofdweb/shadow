<?php

use yii\helpers\Html;
use common\widgets\detail\DetailView;

?>
<div class="box box-primary">
    <div class="box-body">
        <?= Html::img($model->profile->avatarThumb, ['class' => 'profile-user-img img-responsive img-circle', 'alt' => Yii::t('app', 'Профиль')]) ?>
        <h3 class="profile-username text-center"><?= $model->user->username ?></h3>
      
        <p class="text-muted text-center">
          <?= Html::itemsGroup($model->user->roles, 'name', 'span', ' | ') ?>
        </p>
      
        <?= DetailView::widget([
            'model' => $model->user,
            'formatter' => [
              'class' => 'common\widgets\detail\DetailFormatter'
            ],
            'attributes' => [
                'email',
                'status_id:status',
                'profile.last_vizit_at:datetime'
            ],
        ]) ?>
      
        <?= Html::a(Html::fa('edit') . Yii::t('app', 'Изменить'), ['update', 'id' => $model->user->id], ['class' => 'btn btn-primary btn-block']) ?>
    </div>
</div>