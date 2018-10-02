<?php

namespace modules\file\components\styles;

class PageStyle extends BaseStyle
{
  private $_name = 'Thumb';
  
  public $uri = 'page';
  
  protected $width = 256;
  
  protected $height = 186;
  
  protected $options = ['jpeg_quality' => 100];
}