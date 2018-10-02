<?php

namespace modules\article\backend\models;

use Yii;
use modules\article\models\Article as BaseModel;

class Article extends BaseModel
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
          'image' => Yii::t('app', 'Изображения'),
          'images' => Yii::t('app', 'Изображения'),
          'tags' => Yii::t('app', 'Теги')
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
          'class' => \modules\tag\backend\behaviors\TagBehavior::className()
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
