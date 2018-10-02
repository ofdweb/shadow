<?php

namespace modules\product\frontend\models;

use Yii;
use modules\product\models\Product as BaseModel;
use modules\tag\frontend\models\ProductOption;

class Product extends BaseModel
{
    public static function itemBySlug($slug)
    {
        return self::find()->joinWith(['options', 'images'])->where(['slug' => $slug])->active()->one();
    }
    
    public function getOptions()
    {
        return $this->hasMany(ProductOption::className(), ['id' => 'tag_id'])
            ->viaTable('tag_relation', ['entity_id' => 'id'], function($query) {
                $query->onCondition(['tag_relation.entity' => $this->formName()]);
            })->with(['mainImage']);
    }
}