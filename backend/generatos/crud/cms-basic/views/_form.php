<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\bootstrap\Tabs;
use yii\widgets\ActiveForm;
use backend\widgets\EditAdvancedWidget;
use common\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form box box-solid">
    <?= "<?php Pjax::begin(['isForm' => true, 'options' => ['class' => 'box-body no-padding']]); ?>" ?>
        <?= "<?php " ?>$form = ActiveForm::begin(['options' => ['data-pjax' => true]]); ?>
            <div class="row">
                <div class="col-md-8">
                    <div class="nav-tabs-custom">
                        <?= "<?= " ?>Tabs::widget([
                            'items' => [
                                [
                                  'label' => Yii::t('app', 'Содержимое'),
                                  'content' => $this->render('tabs/_content', compact('model')),
                                ]
                            ],
                        ]); ?>

                        <div class="box-footer">
                            <?= "<?= Html::saveButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success btn-flat']) ?>" ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                  <?= "<?= " ?>EditAdvancedWidget::widget([
                      'model' => $model
                  ]); ?>
                </div>
            </div>
        <?= "<?php " ?>ActiveForm::end(); ?>
    <?= "<?php Pjax::end(); ?>\n" ?>
</div>
