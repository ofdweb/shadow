<?php

namespace backend\controllers\services;
 
use Yii;
use yii\base\Component;

class EmployeeService extends Component
{
    protected $_model;
  
    const EVENT_AFTER_FIND = 'afterFind';
  
    const EVENT_BEFORE_UPDATE = 'beforeUpdate';
  
    const EVENT_AFTER_UPDATE = 'afterUpdate';
  
    const EVENT_BEFORE_DELETE = 'beforeDelete';
  
    const EVENT_AFTER_DELETE = 'afterDelete';
  
    const EVENT_AFTER_ACTION = 'afterAction';
  
    public function __construct($modelClass)
    {
        $this->_model = $modelClass::instance();
        parent::__construct();
    }

    public function search()
    {
        return $this->_model->search(Yii::$app->request->queryParams);
    }
  
    public function findModel($id)
    {
        return $this->_model::find()->byId($id);
    }
  
    public function afterFind()
    {
        $this->trigger(self::EVENT_AFTER_FIND);
    }
  
    public function load()
    {
        return $this->_model->load(Yii::$app->request->post());
    }
  
    public function afterSave() 
    {
        $this->trigger(self::EVENT_AFTER_UPDATE);
    }
  
    protected function saveFlashMessage($event)
    {
        if (!$this->_model->hasErrors()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Данные успешно сохранены')); 
        } else {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Не удалось выполнить сохранение')); 
        }
    }
  
    protected function deleteFlashMessage($event)
    {
        if (!$this->_model) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Данные успешно удалены')); 
        } else {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Не удалось выполнить удаление')); 
        }
    }
  
    public function beforeSave()
    {
        $this->trigger(self::EVENT_BEFORE_UPDATE);
        return true;
    }
  
    public function getPrimaryKey()
    {
        return $this->_model->primaryKey;
    }
  
    public function setModel($value)
    {
        $this->_model = $value;
        return $this;
    }
  
    public function getModel()
    {
        return $this->_model;
    }
  
    public function delete()
    {
        if ($this->_model->delete()) {
            $this->_model = null;
        }
      
        $this->trigger(self::EVENT_AFTER_ACTION);
    }
  
    public function save()
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {
          if ($this->beforeSave() && $this->_model->save()) {
            $this->afterSave();
            
            $transaction->commit();
            
            $this->trigger(self::EVENT_AFTER_ACTION);
            return true;
          }
        } catch (Exception $e) {
            $transaction->rollback();
            throw $e;
        }
      
        $transaction->rollback();
      
        $this->trigger(self::EVENT_AFTER_ACTION);
        return;
    }
}