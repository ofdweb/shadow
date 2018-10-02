<?php

namespace modules\menu\backend\components;

class MenuAdvanced extends \backend\components\BaseAdvanced
{
  public $icon = 'indent';
  
  public $view = 'menu_advanced';
  
  public $modelAttribute = 'menu';
  
  public $module = 'menu';
  
  public $label = 'Выбор меню';
}