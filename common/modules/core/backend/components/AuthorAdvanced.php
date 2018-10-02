<?php

namespace modules\core\backend\components;

class AuthorAdvanced extends \backend\components\BaseAdvanced
{
  public $icon = 'users';
  
  public $view = 'author_advanced';
  
  public $label = 'Информация об авторе';
  
  public $module = 'core';
  
  public $weight = 5;
  
  public function enabled($model)
  {
    return parent::enabled($model) && $model->hasProperty('created_by');
  }
}