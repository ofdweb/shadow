<?php

namespace common\modules\file;

use Yii;
use modules\file\components\FileManager;

/**
 * file module definition class
 */
class Module extends \yii\base\Module
{
    public static $defaultStorage = 'LocalStorage';
  
    public function getManager($storage = null)
    {
        return new FileManager(['storage' => ($storage ?: self::$defaultStorage)]);
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        //Yii::configure($this, require __DIR__ . '/config.php');
        // custom initialization code goes here
    }
}
