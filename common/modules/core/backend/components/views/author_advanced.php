<?php

use bs\Flatpickr\FlatpickrWidget;
use modules\user\models\User;
use modules\user\widgets\UserSelect2Widget;

?>

<?= $form->field($model, 'created_by')
  ->widget(UserSelect2Widget::classname(), [
    'admin' => true
  ])
  ->hint(Yii::t('app', 'Автор материала. По умолчанию текущий пользователь'))
?>

<?php if ($model->hasProperty('published_at')): ?>
    <?= $form->field($model, 'published_at')->widget(FlatpickrWidget::class, [
        'options' => [
            'class' => 'form-control',
        ],
        'groupBtnShow' => true,
        'clientOptions' => [
            'allowInput' => true,
            'defaultDate' => $model->published_at ? $model->published_at : date(DATE_ATOM),
            'enableTime' => true,
            'time_24hr' => true,
        ],
    ])->hint(Yii::t('app', 'Время публикации материала. По умолчанию текущее время'))
    ?>
<?php endif; ?>