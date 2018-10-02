<?php

namespace modules\metatag\backend\components;

class MetatagAdvanced extends \backend\components\BaseAdvanced
{
  public $icon = 'tags';
  
  public $view = 'metatag_advanced';
  
  public $label = 'Мета-теги';
  
  public $attributes = ['metatag'];
  
  public $module = 'metatag';
}