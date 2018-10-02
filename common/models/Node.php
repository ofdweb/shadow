<?php

namespace common\models;

use yii2tech\filedb\ActiveRecord;
use yii\helpers\ArrayHelper;

class Node extends ActiveRecord
{
    public static function fileName()
    {
        return 'Node';
    }
  
    public function menuList()
    {
        return ArrayHelper::map(self::find()->where(['id' => ['Page']])->orderBy(['id' => SORT_DESC])->All(), 'id', 'name');
    }
  
    public function itemList()
    {
        return ArrayHelper::map(self::find()->orderBy(['id' => SORT_DESC])->All(), 'id', 'name');
    }
}