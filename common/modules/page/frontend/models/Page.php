<?php

namespace modules\page\frontend\models;

use Yii;
use modules\page\models\Page as BaseModel;

class Page extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function find()
    {
        return parent::find()->active();
    }
  
    public static function itemById($id)
    {
        return self::find()->with(['images'])->byId($id);
    }
  
    public static function itemBySlug($slug)
    {
        return self::find()->with(['images'])->where(['slug' => $slug])->one();
    }
  
    public function getAnnonce()
    {
        return $this->description;
    }
}