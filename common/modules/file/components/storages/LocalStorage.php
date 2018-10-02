<?php

namespace modules\file\components\storages;

use Yii;
use yii\helpers\FileHelper;
use modules\file\components\FileObject;

class LocalStorage extends BaseStorage
{
    public $uri = 'uploads';
  
    private $_uploadDir;
  
    function init() 
    {
       parent::init();
       $this->_uploadDir = Yii::getAlias('@frontend/web/uploads');
    }
  
    public function upload(FileObject $file)
    {
        $remotePath = $this->_uploadDir . ($file->uri ? (DIRECTORY_SEPARATOR . $file->uri) : null);

        $this->checkExistDir($remotePath);

        while (file_exists($remotePath . DIRECTORY_SEPARATOR . $file->name)) {
          $file->generateFileName();
        }
      
        $remotePath .=  DIRECTORY_SEPARATOR . $file->name;
      
        if (is_uploaded_file($file->tempName)) {
          $file->error = $file->saveAs($remotePath) ? UPLOAD_ERR_OK : 601;
        } else {
          $file->error = rename($file->tempName, $remotePath) ? UPLOAD_ERR_OK : 601;
        }

        return $file;
    }
  
    public function sourcePath(FileObject $file)
    {
        $remotePath = $this->_uploadDir . ($file->uri ? (DIRECTORY_SEPARATOR . $file->uri) : null) . DIRECTORY_SEPARATOR . $file->name;
        return file_exists($remotePath) ? $remotePath : null;
    }
/*
    public function createThumb(FileObject $sourceFile, FileObject $thumbFile)
    {
        if ($style = $thumbFile->style) {
            $remotePath = $this->uri . DIRECTORY_SEPARATOR . $thumbFile->uri . DIRECTORY_SEPARATOR . $style->uri;
            $this->checkExistDir($remotePath);

            $style->setSourceFile($this->uri . DIRECTORY_SEPARATOR . $sourceFile->remotePath)
              ->setRemoteFile($remotePath . DIRECTORY_SEPARATOR . $thumbFile->name)
              ->execute();  
        } else {
            $thumbFile->error = 602;
        }
      
        return $thumbFile;
    }
  
    public function deleteThumb(FileObject $file)
    {
        if ($style = $file->style) {
            $remotePath = $this->uri . DIRECTORY_SEPARATOR . $thumbFile->uri . DIRECTORY_SEPARATOR . $style->uri . DIRECTORY_SEPARATOR .  $file->name;
            FileHelper::unlink($remotePath); 
        }
    } 
  */
    public function remove(FileObject $file)
    {
        $remotePath = DIRECTORY_SEPARATOR . $this->uri . ($file->uri ? (DIRECTORY_SEPARATOR . $file->uri) : null) . DIRECTORY_SEPARATOR . $file->name;
        FileHelper::unlink($remotePath);
    }
  
    public function srcPath(FileObject $file)
    {
        $remotePath = DIRECTORY_SEPARATOR . $this->uri . ($file->uri ? (DIRECTORY_SEPARATOR . $file->uri) : null) . DIRECTORY_SEPARATOR . $file->name;
        return $this->sourcePath($file) ? $remotePath : null;
      /*
        $result = DIRECTORY_SEPARATOR . 'uploads' . ($file->uri ? (DIRECTORY_SEPARATOR . $file->uri) : null );
      
        if ($file->style) {
          $result .= DIRECTORY_SEPARATOR . 'styles' . DIRECTORY_SEPARATOR . $file->style->uri;
          
          if (!file_exists($result . DIRECTORY_SEPARATOR . $file->name)) {
            $file->createThumb($file->style);
          }
        }

        return $result . DIRECTORY_SEPARATOR . $file->name;*/
    }
  
    public function list($remotePath = '', $options = [])
    {
        return array_map(function($path) use ($remotePath) {
            return FileObject::instanceByPath($path, [
                'uri' => $remotePath,
                'storage' => (new \ReflectionClass($this))->getShortName()
            ]);
        }, FileHelper::findFiles(($this->_uploadDir . DIRECTORY_SEPARATOR . $remotePath), $options));
    }
  
    private function checkExistDir($dirPath)
    {
        if (!is_dir($dirPath)) {
          FileHelper::createDirectory($dirPath);
        }
    }
}