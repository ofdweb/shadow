<?php

namespace modules\tag\backend\models;

use Yii;
use modules\tag\models\Tag as BaseModel;
use yii\db\Query;
use modules\file\models\FileManaged;

class ProductOption extends BaseModel
{     
    public $image;
  
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
          [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg']
        ]);
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
                
        $behaviors['exchange_log'] = \backend\components\ExchangeLogBehavior::className();
        
        $behaviors['image'] = [
          'class' => \modules\file\behaviors\FileBehavior::className(),
          'relation' => 'mainImage',
          'attribute' => 'image'
        ];
      
        return $behaviors;
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
          'image' => Yii::t('app', 'Изображение'),
          'mainImage' => Yii::t('app', 'Изображение'),
        ]);
    }
    
    /**
     * @inheritdoc
     */
    public static function find()
    {
        return (parent::find())->where([self::tableName() . '.type' => self::TYPE_OPTION_PRODUCT]);
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
    
    public function getMainImage()
    {
        return $this->hasOne(FileManaged::className(), ['id' => 'fid'])
            ->viaTable('file_usage', ['entity_id' => 'id'], function($query) {
                $query->onCondition(['entity' => $this->formName(), 'type' => 'mainImage']);
            });
    }
}
