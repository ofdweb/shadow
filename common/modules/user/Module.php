<?php

namespace common\modules\user;

use Yii;

/**
 * user module definition class
 */
class Module extends \yii\base\Module
{
    public function getContextualLinks()
    {
        $id = Yii::$app->request->get('id');
        $visible = Yii::$app->request->get('id', false);

        return [
          ['label' => Yii::t('app', 'Список'), 'url' => ['/user/default/index']],
          ['label' => Yii::t('app', 'Создать'), 'url' => ['/user/default/create']],
          ['label' => Yii::t('app', 'Изменить'), 'url' => ['/user/default/update', 'id' => $id], 'visible' => $visible],
          ['label' => Yii::t('app', 'Просмотр'), 'url' => ['/user/default/view', 'id' => $id], 'visible' => $visible],
          ['label' => Yii::t('app', 'Удалить'), 'url' => ['/user/default/delete', 'id'=> $id], 'visible' => $visible]
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
