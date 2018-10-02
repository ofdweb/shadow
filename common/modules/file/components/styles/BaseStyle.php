<?php

namespace modules\file\components\styles;

use Yii;
use yii\imagine\Image;
use yii\base\BaseObject;

abstract class BaseStyle extends BaseObject
{
  public $uri;
  
  private $_name;
  
  protected $width;
  
  protected $height;
  
  protected $_sourceFile;
  
  protected $_remoteFile;
  
  protected $options = [];
  
  public function getName()
  {
    return Yii::t('app', $this->_name);
  }
  
  public function setSourceFile($value)
  {
    $this->_sourceFile = $value;
    return $this;
  }
  
  public function setRemoteFile($value)
  {
    $this->_remoteFile = $value;
    return $this;
  }
  
  public function execute($options = [])
  {
      $options = array_merge($options, $this->options);
      return Image::thumbnail($this->_sourceFile, $this->width, $this->height)
        ->save($this->_remoteFile, $options);
  }
}