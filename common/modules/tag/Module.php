<?php

namespace common\modules\tag;

use Yii;

/**
 * tags module definition class
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
  
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
