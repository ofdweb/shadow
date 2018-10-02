<?php

namespace modules\menu\backend\models;

use Yii;
use modules\menu\models\Menu as BaseModel;
use modules\file\models\FileManaged;

class CatalogMenu extends BaseModel
{ 
    public $image;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['title'], 'required'],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ]);
    }
    
    /**
     * @inheritdoc
     */
    public static function find()
    {
        return (parent::find())->where(['tree' => self::CATALOG_MENU]);
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
          'image' => Yii::t('app', 'Изображение'),
          'images' => Yii::t('app', 'Изображение')
        ]);
    }
  
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['slug'] = [
            'class' => \yii\behaviors\SluggableBehavior::className(),
            'attribute' => 'title',
        ];
        
        $behaviors['image'] = [
          'class' => \modules\file\behaviors\FileBehavior::className(),
          'relation' => 'images',
          'attribute' => 'image'
        ];
        
        $behaviors['exchange_log'] = [
            'class' => \backend\components\ExchangeLogBehavior::className(),
        ];
      
        return $behaviors;
    }
    
    /**
     * @return \yii\db\ActiveQuery
    */  
    public function getImages()
    {
        return $this->hasOne(FileManaged::className(), ['id' => 'fid'])
            ->viaTable('file_usage', ['entity_id' => 'id'], function($query) {
                $query->onCondition(['file_usage.entity' => $this->formName(), 'file_usage.type' => 'files']);
            });
    }
}