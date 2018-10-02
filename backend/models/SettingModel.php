<?php

namespace backend\models;

use Yii;
use yii2mod\settings\models\SettingModel as BaseModel;
  
class SettingModel extends BaseModel
{
    public function setSetting($section, $key, $value, $type = null): bool
    {
        $result = parent::setSetting($section, $key, $value, $type);
      
        if (!$result) {
          return static::removeSetting($section, $key);
        }
      
        return $result;
    }
}