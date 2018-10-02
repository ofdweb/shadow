<?php

namespace modules\file\components;

use Yii;
use yii\web\UploadedFile;
use modules\file\models\FileManaged;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;

class FileObject extends UploadedFile
{
  public $uri;
  
  private $_originBaseName;
  
  private $_iterat = 0;
  
  private $_storage;
  
  public $error = UPLOAD_ERR_OK;
  
  //private $_style;
  
  public function init()
  {
      parent::init();
      $this->_originBaseName = $this->baseName;
  }
  
  public static function instanceManaged(FileManaged $fileManaged)
  {
      $data = ArrayHelper::toArray($fileManaged, [
          FileManaged::className() => ['name', 'size', 'type' => 'mime', 'uri', 'storage'],
      ]);
      return new self($data);
  }
  
  public static function instanceByPath($path, $attributes = [])
  {
      $name = basename($path);
      
      return new self(array_merge([
        'name' => $name,
        'size' => filesize($path),
        'type' => FileHelper::getMimeType($path),
      ], $attributes));
  }
  
  public function createManaged()
  {
      $data = ArrayHelper::toArray($this, [
          FileObject::className() => [
            'name',
            'size',
            'mime' => 'type',
            'uri',
            'storage' => function ($model) { 
              return (new \ReflectionClass($model->storage))->getShortName(); 
            }
          ],
      ]);
          
      $model = new FileManaged($data);
      return $model->save() ? $model : null;
  }

  public function setStorage($value = null)
  {
      $value = $value ?: Yii::$app->getModule('file')::$defaultStorage;
      $this->_storage = is_object($value) ? $value : Yii::createObject("\\modules\\file\\components\\storages\\" . $value);
      return $this;
  }
  
  public function getStorage()
  {
      return $this->_storage ?: $this->setStorage()->_storage;
  }
  
  public function setUri($value)
  {
      $this->uri = $value;
      return $this;
  }
/*
  public function setStyle($value)
  {
      $this->_style = is_object($value) ? $value : Yii::createObject("\\modules\\file\\components\\styles\\" . $value);
      return $this;
  }

  public function getStyle()
  {
      return $this->_style;
  }
  
  public function unsetStyle()
  {
      $this->_style = null;
      return $this;
  }
  */
/*
  public function getBasePath()
  {
      return $this->uri . DIRECTORY_SEPARATOR . $this->name;
  }
*/
  public function thumbSrc($style, $autoCreate = true)
  {
      $style = $this->initStyle($style);
      $thumbFile = clone $this;
        
      $uri = ($this->uri ? $this->uri . DIRECTORY_SEPARATOR : null) . 'styles' . DIRECTORY_SEPARATOR . $style->uri;
      $thumbFile->setUri($uri);
        
      $path = $thumbFile->storage->srcPath($thumbFile);

      if (!$path && $autoCreate) {
        return $this->createThumb($style)->thumbSrc($style, false);
      }
    
      return $path;
  }
  
  public function getSrc()
  {
      return $this->storage->srcPath($this);
  }

  public function generateFileName()
  {
      $this->name = $this->_originBaseName . '-' . $this->_iterat . '.' . $this->extension;
      $this->_iterat ++;
  }

  public function getIsImage()
  {
      return true;
  }
 
  public function upload()
  {
      return $this->storage->upload($this);
  }

  public function remove()
  {
      return $this->storage->remove($this);
  }
  
  private function initStyle($style)
  {
    return is_object($style) ? $style : Yii::createObject("\\modules\\file\\components\\styles\\" . $style);
  }
  /*
  public function deleteStyles()
  {
      foreach ($this->_storage::$styleList as $style) {
          $this->deleteThumb($style);
      }
      return $this;
  }

  public function createStyles()
  {
      foreach ($this->_storage::$styleList as $style) {
          $this->createThumb($style);
      }
      return $this;
  }
*/
  public function createThumb($style)
  {
      if (!$this->error && $this->isImage) {
        $thumbFile = clone $this;

        $style = $this->initStyle($style);
        $thumbFile->tempName = Yii::getAlias('@tmp') . DIRECTORY_SEPARATOR . uniqid();

        if ($sourcePath = $this->storage->sourcePath($this)) {
          $style->setSourceFile($sourcePath)
              ->setRemoteFile($thumbFile->tempName);
          
          if ($style->execute()) {
              $uri = ($this->uri ? $this->uri . DIRECTORY_SEPARATOR : null) . 'styles' . DIRECTORY_SEPARATOR . $style->uri;
              $thumbFile->setUri($uri)->upload();
          }
        }
      }
    
      return $this;
  }
  
  public function deleteThumb($style)
  {
      if (!$this->error && $this->isImage) {
        $thumbFile = clone $this;
        
        $style = $this->initStyle($style);
        $uri = ($this->uri ? $this->uri . DIRECTORY_SEPARATOR : null) . 'styles' . DIRECTORY_SEPARATOR . $style->uri;
        
        $thumbFile->setUri($uri)->delete();

        return $this;
      }
  }
}