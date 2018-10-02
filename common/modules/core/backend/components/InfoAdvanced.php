<?php

namespace modules\core\backend\components;

class InfoAdvanced extends \backend\components\BaseAdvanced
{
  public $icon = 'info';
  
  public $view = 'info_advanced';
  
  public $label = 'Основная информация';
  
  public $module = 'core';
  
  public $weight = 1;
  
  public $type = self::TYPE_BOX;
  
  public function enabled($model)
  {
      return parent::enabled($model) && ($model->hasProperty('created_by') || $model->hasProperty('created_at'));
  }
}