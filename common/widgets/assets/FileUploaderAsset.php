<?php

namespace common\widgets\assets;

use Yii;
use yii\web\AssetBundle;

/**
 * Widget asset bundle
 */
class FileUploaderAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@common/widgets/web/';
    /**
     * @inheritdoc
     */
    public $css = [
        'css/fileuploader.min.css'
    ];
    /**
     * @inheritdoc
     */
    public $js = [
        'js/fileuploader.min.js'
    ];
    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
    ];

    public function addTheme($theme = null)
    {
        if ($theme) {
            if ($this->checkExists("css/fileuploader-theme-{$theme}.css")) {
                $this->css[] = "css/fileuploader-theme-{$theme}.css";
            }
        }

        return $this;
    }
  
    private function checkExists($path)
    {
        return file_exists(Yii::getAlias($this->sourcePath . DIRECTORY_SEPARATOR . $path));
    }
}