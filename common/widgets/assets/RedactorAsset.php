<?php

namespace common\widgets\assets;

use Yii;

class RedactorAsset extends \yii\web\AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@common/widgets/web/';
    /**
     * @inheritdoc
     */
    public $css = [
        'css/redactor.min.css'
    ];
    /**
     * @inheritdoc
     */
    public $js = [
        'js/redactor.min.js'
    ];
    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
    ];

    public function setLang($value)
    {
        if ($this->checkExists("redactor/lang/{$value}.js")) {
            $this->js[] = "redactor/lang/{$value}.js";
        }
    }
  
    public function setPlugin($value)
    {
        if ($this->checkExists("redactor/plugins/" . $value . DIRECTORY_SEPARATOR . $value . ".min.css")) { 
            $this->css[] = "redactor/plugins/" . $value . DIRECTORY_SEPARATOR . $value . ".min.css";
        }
      
        if ($this->checkExists("redactor/plugins/" . $value . DIRECTORY_SEPARATOR . $value . ".min.js")) { 
            $this->js[] = "redactor/plugins/" . $value . DIRECTORY_SEPARATOR . $value . ".min.js";
        }
    }
  
    private function checkExists($path)
    {
        return file_exists(Yii::getAlias($this->sourcePath . DIRECTORY_SEPARATOR . $path));
    }
}