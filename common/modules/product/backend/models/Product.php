<?php

namespace modules\product\backend\models;

use Yii;
use modules\product\models\Product as BaseModel;

class Product extends BaseModel
{
    public $image;
  
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
          [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
          [['published_at'], 'filter', 'filter' => function ($value) {
             return $value ? (int)Yii::$app->formatter->asTimestamp($value) : (int)Yii::$app->formatter->asTimestamp('NOW');
          }],
        ]);
    }
  
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
          'image' => Yii::t('app', 'Изображение'),
          'images' => Yii::t('app', 'Изображение'),
          'tags' => Yii::t('app', 'Опции')
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

        $behaviors['metatag'] = [
          'class' => \modules\metatag\backend\behaviors\MetaTagBehavior::className()
        ];
      
        $behaviors['tags'] = [
          'class' => \modules\tag\backend\behaviors\TagBehavior::className(),
          'className' => '\modules\tag\backend\models\ProductOption',
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
     * @inheritdoc
     */
    public function afterFind()
    {
        parent::afterFind();
        $this->published_at = Yii::$app->formatter->asDatetime($this->published_at);
    }
}
