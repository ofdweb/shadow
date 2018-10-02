<?php

namespace modules\file\components\styles;

class ProductThumbStyle extends BaseStyle
{
  private $_name = 'ProductThumb';
  
  public $uri = 'product_thumb';
  
  protected $width = 155;
  
  protected $height = 203;
  
  protected $options = ['jpeg_quality' => 100];
}