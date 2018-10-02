<?php

namespace modules\tag\backend\models;

use Yii;
use modules\tag\models\Tag as BaseModel;
use yii\db\Query;

class Tag extends BaseModel
{     
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['exchange_log'] = \backend\components\ExchangeLogBehavior::className();
      
        return $behaviors;
    }
  
    /**
     * @inheritdoc
     */
    public static function find()
    {
        return (parent::find())->where([self::tableName() . '.type' => self::TYPE_DEFAULT]);
    }
    
    /**
     * @inheritdoc
     */
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_DELETE,
        ];
    }
  
    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        (new Query)
          ->createCommand()
          ->delete('tag_relation', ['tag_id' => $this->id])
          ->execute();
      
        return parent::beforeDelete();
    }
}
