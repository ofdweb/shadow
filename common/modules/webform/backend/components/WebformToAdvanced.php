<?php

namespace modules\webform\backend\components;

class WebformToAdvanced extends \backend\components\BaseAdvanced
{
  public $icon = 'envelope-square';
  
  public $view = 'webform_to_advanced';

  public $module = 'webform';
  
  public $label = 'Настройки получателя';
  
  public $attributes = ['to_email'];
}