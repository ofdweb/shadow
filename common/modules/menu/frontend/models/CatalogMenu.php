<?php

namespace modules\menu\frontend\models;

use Yii;
use modules\menu\models\Menu as BaseModel;
use modules\file\models\FileManaged;

class CatalogMenu extends BaseModel
{ 
    /**
     * @inheritdoc
     */
    public static function find()
    {
        return (parent::find())->where(['tree' => self::CATALOG_MENU]);
    }
    
    /**
     * @return \yii\db\ActiveQuery
    */  
    public function getImage()
    {
        return $this->hasOne(FileManaged::className(), ['id' => 'fid'])
            ->viaTable('file_usage', ['entity_id' => 'id'], function($query) {
                $query->onCondition(['file_usage.entity' => $this->formName(), 'file_usage.type' => 'files']);
            });
    }
    
    public static function itemBySlug($slug)
    {
        return self::find()->where(['slug' => $slug])->one();
    }
}