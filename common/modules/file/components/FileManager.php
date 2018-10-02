<?php

namespace modules\file\components;

use Yii;
use yii\base\BaseObject;
use modules\file\components\FileObject;

class FileManager extends BaseObject
{
    private $_storage;
  
    private $_remoteUrl;
  
    private $_options = [];

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
  
    public function deleteStyles(FileObject $file)
    {
        foreach ($file->storage::$styleList as $style) {
            $file->deleteThumb($style);
        }
        return $this;
    }

    public function createStyles(FileObject $file)
    {
        foreach ($file->storage::$styleList as $style) {
            $file->createThumb($style);
        }
        return $this;
    }
  
    public function remoteDir($remotePath)
    {
        $this->_remoteUrl = $remotePath;
        return $this;
    }
  
    public function byParams($options = [])
    {
        $this->_options = $options;
        return $this;
    }
  
    public function typeImg()
    {
        return $this->byParams(array_merge([
          'only' => ['*.jpg', '*.jpeg', '*.png', '*.bmp'],
          'recursive' => false
        ], $this->_options));
    }
  
    public function list()
    {
      $files = $this->storage->list($this->_remoteUrl, $this->_options);
      return $files;
    }
}