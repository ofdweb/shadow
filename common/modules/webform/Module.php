<?php

namespace common\modules\webform;

use Yii;

/**
 * webform module definition class
 */
class Module extends \yii\base\Module
{
    public function getContextualLinks()
    {
        $id = Yii::$app->request->get('id');
        $visible = Yii::$app->request->get('id', false);

        return [
          ['label' => Yii::t('app', 'Настройки'), 'url' => ['form', 'id' => $id], 'visible' => $visible, 'icon' => 'cog'],
          ['label' => Yii::t('app', 'Результат'), 'url' => ['result', 'id' => $id], 'visible' => $visible, 'icon' => 'table'],
        ];
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
