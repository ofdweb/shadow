<?php

namespace modules\core\backend\components;

class SlugAdvanced extends \backend\components\BaseAdvanced
{
  public $icon = 'cogs';
  
  public $view = 'slug_advanced';
  
  public $label = 'Настройки адресов';
  
  public $module = 'core';
  
  public $weight = 0;
  
  public function enabled($model)
  {
    return parent::enabled($model) && $model->hasProperty('slug');
  }
}