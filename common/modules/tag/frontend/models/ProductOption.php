<?php

namespace modules\tag\frontend\models;

use Yii;
use modules\tag\models\Tag as BaseModel;
use modules\file\models\FileManaged;

class ProductOption extends BaseModel
{         
    /**
     * @inheritdoc
     */
    public static function find()
    {
        return (parent::find())->where([self::tableName() . '.type' => self::TYPE_OPTION_PRODUCT]);
    }
    
    public function getMainImage()
    {
        return $this->hasOne(FileManaged::className(), ['id' => 'fid'])
            ->viaTable('file_usage', ['entity_id' => 'id'], function($query) {
                $query->onCondition(['entity' => $this->formName(), 'type' => 'mainImage']);
            });
    }
}
