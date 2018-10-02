<?php

namespace common\modules\product;

use Yii;

/**
 * product module definition class
 */
class Module extends \yii\base\Module
{
    public function getContextualLinks()
    {
        $id = Yii::$app->request->get('id');
        $visible = Yii::$app->request->get('id', false);

        return [
          ['label' => Yii::t('app', 'Список'), 'url' => ['index']],
          ['label' => Yii::t('app', 'Создать'), 'url' => ['create']],
          ['label' => Yii::t('app', 'Изменить'), 'url' => ['update', 'id' => $id], 'visible' => $visible],
          ['label' => Yii::t('app', 'Просмотр'), 'url' => ['view', 'id' => $id], 'visible' => $visible],
          ['label' => Yii::t('app', 'Удалить'), 'url' => ['delete', 'id'=> $id], 'visible' => $visible]
        ];
    }
    
    public function bootstrapFrontend($app)
    {
        $app->getUrlManager()->addRules([
            'product/<slug>' => 'product/default/view',
            'product/catalog/<slug>' => 'product/catalog/view',
            'product/catalog/<slug>/items' => 'product/catalog/items',
        ], false);
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
