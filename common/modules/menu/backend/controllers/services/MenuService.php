<?php

namespace common\modules\menu\backend\controllers\services;
 
use Yii;
use backend\controllers\services\EmployeeService;
use common\models\Node; 

class MenuService extends EmployeeService
{
    public function init()
    {
        parent::init(); 
        $this->_model->tree = $this->_model::MAIN_MENU;
    }
  
    /**
     * @inheritdoc
    */ 
    public function afterFind ()
    {
        parent::afterFind();
        
        $this->_model->setAttributes([
            'parent_id' => $this->_model->parent->id,
            'link_object' => $this->_model->hasEntity
        ]);
    }
  
    /**
     * @inheritdoc
    */
    public function beforeSave()
    {
        $model = null;
      
        if ($this->_model->link_object && $this->_model->hasEntity) {
            $node = Node::findOne($this->_model->entity);
            $model = $node->class::find()->byId($this->_model->entity_id);

            if ($model) {
              $this->_model->setAttributes([
                  'slug' => $model->slug,
                  'title' => $this->_model->title ?: $model->title
              ]);
            }
        }
      
        if (!$model) {
            $this->_model->setAttributes([
                'entity' => null,
                'entity_id' => null,
                'link_object' => false
            ]);
        }
      
        return parent::beforeSave();
    }
  
    /**
     * @inheritdoc
    */ 
    public function save()
    {
        if (!$this->_model->validate() || !$this->beforeSave()) {
          return;
        }
      
        $toItem = $this->_model::findOne($this->_model->parent_id);
        $this->_model->appendTo($toItem);
        $this->_model->setAttribute('updated_by', Yii::$app->user->getId());
      
        if (!$this->_model->save()) {
          return;
        }

        $this->trigger(self::EVENT_AFTER_ACTION);
        return true;
    }
}