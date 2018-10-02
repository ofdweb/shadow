<?php

namespace backend\themes\basic\assets;

use Yii;
use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class ThemeAsset extends AssetBundle
{
    public $css = [
        'css/theme.css',
    ];
  
    public $js = [
    ];
  
    public $depends = [
        'backend\assets\AppAsset',
    ];
  
    public $publishOptions = [
        'forceCopy' => true,
    ];
  
    public function init()
    {
        parent::init();
        $this->sourcePath = Yii::$app->view->theme->basePath;
    }
}
