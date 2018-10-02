<?php

namespace modules\menu\backend\behaviors;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Behavior;
use modules\menu\backend\models\MenuAdvanced as Menu;
use yii\web\Request;

class MenuBehavior extends Behavior
{
    public $relation = 'menu';
  
    public $tree;
  
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
          ActiveRecord::EVENT_INIT => 'initModel',
          ActiveRecord::EVENT_AFTER_FIND => 'afterFind',
          ActiveRecord::EVENT_AFTER_VALIDATE => 'afterValidate',
          ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
          ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
          ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
      ];
    }
  
    public function initModel($event)
    {
        $this->owner->menu = new Menu([
          'entity' => $this->owner->formName(),
          'tree' => $this->tree
        ]);
    }
  
    public function afterFind($event)
    {
        $relations = $event->sender->getRelatedRecords();
        if (isset ($relations[$this->relation]) && $relations[$this->relation]) {
          $this->owner->menu = $relations[$this->relation];
          
          $this->owner->menu->setAttributes([
            'parent_id' => $this->owner->menu->parent ? $this->owner->menu->parent->id : 0,
            'create_link' => true
          ]);
        }
    }
  
    public function afterValidate($event)
    {
        $this->owner->menu->load(Yii::$app->request->post());
        $this->owner->menu->validate();

        if ($this->owner->menu->hasErrors()) {
            $this->owner->addError($this->relation, $this->owner->menu->getErrors());
        }
    }
    
    public function afterSave($event)
    {
        if ($this->owner->menu->create_link) {
            if ($this->owner->menu->isNewRecord) {
                $menuParent = Menu::findOne($this->owner->menu->parent_id);
                $this->setOwnerAttributes();

                $this->owner->menu->prependTo($menuParent)->save();
            } else {
                //$menuParent = Menu::findOne($this->owner->menu->id)->parent;
                $currentItem = $this->owner->menu->parent;
                $this->setOwnerAttributes();

                if ($currentItem->id != $this->owner->menu->parent_id) {
                    $toItem = Menu::findOne($this->owner->menu->parent_id);
                    $this->owner->menu->appendTo($toItem)->save();
                } else {
                    $this->owner->menu->save();
                }
            }  
        } elseif (!$this->owner->menu->isNewRecord) {
            $this->owner->unlinkAll($this->relation, true);
        }
        
    }
  
    private function setOwnerAttributes()
    {
        $this->owner->menu->setAttributes([
           'title' => $this->owner->menu->title ?: $this->owner->title,
           'slug' => $this->owner->slug,
           'entity_id' => $this->owner->id,
           'status_id' => $this->owner->status_id
        ]);
    }
  
    public function afterDelete($event)
    {
        $this->owner->unlinkAll($this->relation, true);
    }
  
    public function getMenu()
    {
        return $this->owner->hasOne(Menu::className(), ['entity_id' => 'id'])
            ->onCondition([Menu::tableName() . '.entity' => $this->owner->formName()]);
    }
  
    public function setMenu($value)
    {
        $this->owner->menu = $value;
    }
}