<?php

namespace modules\webform\backend\components;

class WebformFromAdvanced extends \backend\components\BaseAdvanced
{
  public $icon = 'send';
  
  public $view = 'webform_from_advanced';

  public $module = 'webform';
  
  public $label = 'Настройки отправителя';
  
  public $attributes = ['from_name', 'from_email'];
}