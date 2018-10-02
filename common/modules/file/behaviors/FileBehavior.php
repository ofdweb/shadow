<?php

namespace modules\file\behaviors;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Behavior;
use yii\helpers\ArrayHelper;
use modules\file\components\FileObject;
use modules\file\models\FileManaged;

class FileBehavior extends Behavior
{
    public $attribute = 'file';
  
    public $relation;
  
    public $unlinkAll = false;
  
    public function init()
    {
        parent::init();
      
        if (!$this->enabled()) {
          $this->detach();
        }
    }
  
    private function enabled()
    {
        return (Yii::$app->id != 'console') && (Yii::$app->request instanceof Request) && (Yii::$app->request->isPost);
    }
    
    public function events()
    {
        return [
            ActiveRecord:: EVENT_AFTER_INSERT => 'afterSave',
            ActiveRecord:: EVENT_AFTER_UPDATE => 'afterSave',
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
        ];
    }
    
    public function afterSave($event)
    {
        $model = $this->owner;
        $attribute = $this->attribute;
        
        $fileManager = Yii::$app->getModule('file')->manager;
        $uploadFiles = FileObject::getInstances($model, $attribute);

        if (!$uploadFiles) {
            return;
        }

        $relation = $model->getRelation($this->relation);
      
        if ($relation->via && $relation->via->on) {
          $linkData = $relation->via->on;
        }
      
        $connection = $model::getDb();
        $transaction = $connection->beginTransaction();
      
        try {
          if ((!$relation->multiple || $this->unlinkAll) && $event->name == ActiveRecord::EVENT_AFTER_UPDATE) {
            $model->unlinkAll($this->relation, true);
          }
          
          foreach ($uploadFiles as $file) {
              $file->setStorage($fileManager->storage)->upload();
              $modelManaged = $file->createManaged();

              if ($modelManaged) {
                $model->link($this->relation, $modelManaged, $linkData);
                $fileManager->createStyles($file);
              } else{
                $file->remove();
              }
          }
              
          $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
            throw $e;
        }
    }
  
    public function afterDelete($event)
    {
        $this->owner->unlinkAll($this->relation, true);
    }
  
    public function unlink($fid)
    {
        $model = FileManaged::find()->byId($fid);
      
        if ($model) {
            $this->owner->unlink($this->relation, $model, true);
        }
    }
}