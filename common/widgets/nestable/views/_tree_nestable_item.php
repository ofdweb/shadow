<?php
use yii\helpers\Html;

?>

<li class="dd-item" data-id="<?= !empty($item['id']) ? $item['id'] : null ?>">
  <span class="dd-handle bg-<?= $item['status'] ?>"></span>
  <div class="dd-content">
    <div class="row">
        <div class="col-md-8">
          <?= $item['name'] ?>
        </div>
        <div class="col-md-4 text-right">
            <?= Html::a((Html::fa('eye') . Yii::t('app', 'Просмотр')), ['view', 'id' => $item['id']], ['class' => ('btn btn-sm btn-info')]) ?>
            <?= Html::a((Html::fa('edit') . Yii::t('app', 'Изменить')), ['update', 'id' => $item['id']], ['class' => ('btn btn-sm btn-primary')]) ?>
            <?= Html::a((Html::fa('trash') . Yii::t('app', 'Удалить')), ['delete', 'id' => $item['id']], [
              'class' => 'btn btn-sm btn-danger',
              'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
              'data-method' => 'post'
            ]) ?>  
        </div>
    </div>
  </div>
  <?php if (isset($item['children']) && count($item['children'])): ?>
      <?= $this->render('tree_nestable', [
        'level' => $item['children'],
        'id' => $id
      ]) ?>
  <?php endif; ?>
</li>