<?php

namespace modules\report\widgets\grid;

use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\grid\DataColumn;
use common\models\Status;

class LogMessageDataColumn extends DataColumn 
{
    public $format = 'raw';
  
    public $attribute = 'message';
  
    public function init()
    {
        parent::init();
      
        if (!$this->label) {
          $this->label = Yii::t('app', 'Действия');
        }
    }
  
    public function getDataCellValue($model, $key, $index)
    {
        $value = $model[$this->attribute];
      
        if (empty($value)) {
          return null;
        } elseif ($value === false) {
          return Yii::t('app', 'Удалил запись');
        } elseif ($value === true) {
          return Yii::t('app', 'Добавил новую запись');
        }

        if (!($message = Json::decode($model[$this->attribute]))) {
          return null;
        }
      
        $result = [];
        $className = null;
      
        if ($list = explode('/', $model['category'])) { 
          list($category, $moduleName, $modelName, $modelId) = $list + ['', '', '', 0];
          $className = $this->getModelClass($moduleName, $modelName);
          
          $result[] = '[' . $className::className() . '][' . $modelId . ']';
        }
      
        foreach ($message as $attribute => $data) {
          $data[0] = $this->valueFormater($attribute, $data[0]);
          $data[1] = $this->valueFormater($attribute, $data[1]);
          
          $result[] = $this->attributeLabel($className, $attribute) . $this->combineValues($data[0], $data[1]);
        }

        return implode("<br/>", $result); 
    }
  
    private function getModelClass($moduleName, $modelName)
    {
        $modelClass = '\\modules\\' . $moduleName . '\\models\\' . $modelName;
        if (class_exists ($modelClass)) {
          return $modelClass::instance();
        }
      
        $modelClass = '\\modules\\' . $moduleName . '\\backend\\models\\' . $modelName;
        if (class_exists ($modelClass)) {
          return $modelClass::instance();
        }
      
        return null;
    }
  
    private function attributeLabel($model, $attribute)
    {
        if (!$model) {
          return;
        }
      
        return Html::label($model->getAttributeLabel($attribute)) . ': ';
    }
  
    private function valueFormater($attribute, $value)
    {
        $value = trim(strip_tags($value));

        if (is_null($value)) {
          return null;
        }
      
        if ($attribute === 'status_id') {
            $status = Status::findOne($value);
            return $status ? $status->name : $value;
        } elseif (strstr($attribute, '_at') && is_numeric($value)) {
            return Yii::$app->formatter->asDatetime($value);
        }
      
        return $value;
    }

    private function combineValues($oldValue, $newValue)
    {
        if ((is_null($oldValue) || empty($oldValue)) && $newValue) {
          return Yii::t('app', 'Добавил значение: {0}', $newValue);
        }

        if ((is_null($newValue) || empty($newValue)) && $oldValue) {
          return Yii::t('app', 'Удалил значение: {0}', $oldValue);
        }
      
        return $oldValue . ' => ' . $newValue;
    }
}