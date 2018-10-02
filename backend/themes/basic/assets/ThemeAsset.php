<?php

namespace backend\themes\basic\assets;

use Yii;
use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class ThemeAsset extends AssetBundle
{
    public $sourcePath = '@backend/themes/basic/web';
  
    public $css = [
        'css/theme.css',
    ];
  
    public $js = [
    ];
  
    public $depends = [
        'backend\assets\AppAsset',
    ];
}
