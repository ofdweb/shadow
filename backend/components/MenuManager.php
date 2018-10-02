<?php

namespace backend\components;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/**
 *
 * @inheritdoc
 */
class MenuManager
{
    public function mainMenu()
    {
        $items = [
            'content' => ['label' => Yii::t('app', 'Содержимое'), 'options' => ['class' => 'header']],
            'user' => ['label' => Yii::t('app', 'Пользователь'), 'options' => ['class' => 'header']],
        ];
        
        foreach (Yii::$app->moduleManager->modules as $name) {
            $module = Yii::$app->getModule($name);
      
            if ($module->hasMethod('getMainMenu')) {
                $items = ArrayHelper::merge($items, $module->getMainMenu());
            }
        }
        
        return $items;
    }
}