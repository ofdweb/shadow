<?php

namespace modules\tag\backend\behaviors;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Behavior;
use yii\web\Request;

class TagBehavior extends Behavior
{
    public $relation = 'tags';
    
    public $className = '\modules\tag\backend\models\Tag';
  
    public function init()
    {
        parent::init();
      
        if (!Yii::$app->request instanceof Request) {
          $this->detach();
        }
    }
    
    public function events()
    {
      return [
          ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
          ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
          ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
      ];
    }
    
    public function afterSave($event)
    {
        if ($event->name == ActiveRecord::EVENT_AFTER_UPDATE) {
          $this->owner->unlinkAll($this->relation, true);
        }

        $post = Yii::$app->request->post($this->owner->formName());
      
        if ($post && isset($post[$this->relation]) && $post[$this->relation]) {
          $relation = $this->owner->getRelation($this->relation);
          $linkData = $relation->via->on;
          
          $connection = $this->owner::getDb();
          $transaction = $connection->beginTransaction();

          try {                                            
            foreach ($post[$this->relation] as $value) {
                if (!is_numeric($value) || !($tag = $this->className::find()->byId($value))) {
                  $tag = new $this->className(['title' => $value]);
                  $tag->save(false);
                }
              
                $this->owner->link($this->relation, $tag, $linkData);
            }
            
            $transaction->commit();
          } catch (Exception $ex) {
              $transaction->rollback();
              throw $ex;
          }
        }
    }
  
    public function afterDelete($event)
    {
        $this->owner->unlinkAll($this->relation, true);
    }
  
    public function getTags()
    {
        return $this->owner->hasMany($this->className::className(), ['id' => 'tag_id'])
            ->viaTable('tag_relation', ['entity_id' => 'id'], function($query) {
                $query->onCondition(['tag_relation.entity' => $this->owner->formName()]);
            });
    }
}