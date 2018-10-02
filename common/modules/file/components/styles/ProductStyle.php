<?php

namespace modules\file\components\styles;

class ProductStyle extends BaseStyle
{
  private $_name = 'Product';
  
  public $uri = 'product';
  
  protected $width = 458;
  
  protected $height = 519;
  
  protected $options = ['jpeg_quality' => 100];
}