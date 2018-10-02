<?php

namespace backend\components;

use Yii;
use yii\helpers\Json;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class ExchangeLogBehavior extends Behavior
{
    const CATEGORY_NAME = 'exchange';
  
    public function init()
    {
        parent::init();
        //$this->detach();
    }
  
    public function events()
    {
        return [
            ActiveRecord:: EVENT_AFTER_INSERT => 'afterInsert',
            ActiveRecord:: EVENT_AFTER_UPDATE => 'afterUpdate',
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
        ];
    }
  
    public function afterInsert($event)
    {
        Yii::info(true, $this->getCategory($event->sender));
    }
  
    public function afterUpdate($event)
    {
        if ($changedAttributes = $event->changedAttributes) {
          unset($changedAttributes['updated_at']);
          unset($changedAttributes['updated_by']);
          
          $message = [];

          foreach ($changedAttributes as $attribute => $value) {
            $message[$attribute] = [$value, $event->sender->{$attribute}];
          }
          
          if ($message) {
            Yii::info(Json::encode($message), $this->getCategory($event->sender));
          }
        }
    }
  
    public function afterDelete($event)
    {
        Yii::info(false, $this->getCategory($event->sender));
    }
  
    private function getCategory($sender)
    {
        $data = explode('\\', $sender::className());
        $moduleName = null;
      
        foreach ($data as $el) {
          if ($el == 'modules') {
            $moduleName = next($data);
            break;
          }
        }

        $pk = is_array($sender->primaryKey) ? implode('_', $sender->primaryKey) : $sender->primaryKey;
        return self::CATEGORY_NAME . DIRECTORY_SEPARATOR . $moduleName . DIRECTORY_SEPARATOR . $sender->formName() . DIRECTORY_SEPARATOR . $pk;
    }
}