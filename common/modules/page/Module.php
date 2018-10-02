<?php

namespace common\modules\page;

use Yii;

/**
 * Page module definition class
 */
class Module extends \yii\base\Module
{ 
    public function getContextualLinks()
    {
        $id = Yii::$app->request->get('id');
        $visible = Yii::$app->request->get('id', false);

        return [
          ['label' => Yii::t('app', 'Список'), 'url' => ['/page/default/index']],
          ['label' => Yii::t('app', 'Создать'), 'url' => ['/page/default/create']],
          ['label' => Yii::t('app', 'Изменить'), 'url' => ['/page/default/update', 'id' => $id], 'visible' => $visible],
          ['label' => Yii::t('app', 'Просмотр'), 'url' => ['/page/default/view', 'id' => $id], 'visible' => $visible],
          ['label' => Yii::t('app', 'Удалить'), 'url' => ['/page/default/delete', 'id'=> $id], 'visible' => $visible]
        ];
    }
  
    public function bootstrapFrontend($app)
    {
        $app->getUrlManager()->addRules([
            'page/<slug>' => 'page/default/view',
        ], false);
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
