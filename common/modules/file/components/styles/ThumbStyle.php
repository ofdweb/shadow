<?php

namespace modules\file\components\styles;

class ThumbStyle extends BaseStyle
{
  private $_name = 'Thumb';
  
  public $uri = 'thumb';
  
  protected $width = 100;
  
  protected $height = 100;
  
  protected $options = ['jpeg_quality' => 90];
}