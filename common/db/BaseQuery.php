<?php

namespace common\db;

use common\models\Status;

class BaseQuery extends \yii\db\ActiveQuery
{
    public function init()
    {
        $this->noTrashed();
        parent::init();
    }
  
    public function active()
    {
        $class = $this->modelClass;
        return $class::instance()->hasProperty('status_id') ? $this->andWhere([$class::tableName() . '.' . 'status_id' => Status::ACTIVE]) : $this;
    }
  
    public function noTrashed()
    {
        $class = $this->modelClass;
        return $class::instance()->hasProperty('is_deleted') ? $this->andWhere(['<>', $class::tableName() . '.' . 'is_deleted', Status::DELETED]) : $this;
    }
  
    public function withTrashed()
    {
        $class = $this->modelClass;
        return $class::instance()->hasProperty('is_deleted') ? $this->andWhere([$class::tableName() . '.' . 'is_deleted' => Status::DELETED]) : $this;
    }
  
    public function byParams($params = []) 
    {
        return $params ? $this->andWhere($params) : $this;
    }
  
    public function byId($id) 
    {
        $class = $this->modelClass;
        $pk = is_array($class::primaryKey()) ? current($class::primaryKey()) : $class::primaryKey();
        return $this->byParams([$class::tableName() . '.' . $pk => $id])->one();
    }
  
    public function allByParams($params = []) 
    {
        return $this->byParams($params)->all();
    }
  
    public function oneByParams($params = []) 
    {
        return $this->byParams($params)->one();
    }
}