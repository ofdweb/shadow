<?php

namespace modules\core\backend\components;

class PublishAdvanced extends \backend\components\BaseAdvanced
{
  public $icon = 'globe';

  public $view = 'publish_advanced';
  
  public $module = 'core';
  
  public $weight = 0;
  
  public $label = 'Настройки публикации';
  
  public function enabled($model)
  {
    return parent::enabled($model) && $model->hasProperty('status_id');
  }
}