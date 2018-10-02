<?php

namespace common\models;

use yii2tech\filedb\ActiveRecord;
use yii\helpers\ArrayHelper;

class Status extends ActiveRecord
{
    const DELETED = 0;
  
    const ACTIVE = 10;
  
    public static function fileName()
    {
        return 'Status';
    }
  
    public function defaultList()
    {
        return ArrayHelper::map(self::find()->where(['id' => [self::ACTIVE, self::DELETED]])->orderBy(['id' => SORT_DESC])->All(), 'id', 'name');
    }
}