<?php

namespace common\widgets\uploader;

use yii\web\JsExpression;
use common\widgets\FileUploader;

class FileUploaderList extends FileUploader
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->theme = 'default';
        parent::init();
    }
  
}