<?php

namespace common\widgets\redactor;

use Yii;
use common\widgets\Redactor as BaseRedactor;

class RedactorLite extends BaseRedactor
{
    protected function plugins()
    {
        return ['fullscreen', 'fontcolor', 'fontsize', 'fontfamily', 'alignment', 'specialchars'];
    }
  
    protected function getDefaultPlugins()
    {
        $data = parent::getDefaultPlugins();
        unset($data['imageUpload']);
        unset($data['fileUpload']);
      
        return $data;
    }
}