<?php

namespace common\modules\menu\backend\controllers\services;

use Yii;
use backend\controllers\services\EmployeeService;

class CatalogService extends EmployeeService
{
    public function init()
    {
        parent::init(); 
        $this->_model->tree = $this->_model::CATALOG_MENU;
        $this->_model->entity = 'Catalog';
    }
    
    /**
     * @inheritdoc
    */ 
    public function afterFind ()
    {
        parent::afterFind();
        
        $this->_model->setAttributes([
            'parent_id' => $this->_model->parent->id
        ]);
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