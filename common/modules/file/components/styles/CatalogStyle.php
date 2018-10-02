<?php

namespace modules\file\components\styles;

class CatalogStyle extends BaseStyle
{
  private $_name = 'Catalog';
  
  public $uri = 'catalog';
  
  protected $width = 256;
  
  protected $height = 220;
  
  protected $options = ['jpeg_quality' => 100];
}