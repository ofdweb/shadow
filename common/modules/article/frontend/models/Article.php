<?php

namespace modules\article\frontend\models;

use Yii;
use modules\article\models\Article as BaseModel;

class Article extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function find()
    {
        return parent::find()->active();
    }
  
    public static function itemListProvider()
    {
        return self::find();
    }
  
        public function getAnnonce()
    {
        return $this->description;
    }
}