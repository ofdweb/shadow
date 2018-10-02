<?php

namespace modules\menu\backend\models;

use Yii;
use modules\menu\models\Menu as BaseModel;
use common\models\Node; 

class MainMenu extends BaseModel
{ 
    public $link_object = false;
  
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['title', 'slug'], 'required', 'when' => function($model) {
              return !$model->link_object;
            }],
            [['link_object'], 'boolean'],
            [['entity_id'], 'unique', 
              'targetAttribute' => ['entity' => 'entity', 'entity_id' => 'entity_id'], 
              'message' => Yii::t('app', 'Материал уже привязан к другому пункту меню')
            ]
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'link_object' => Yii::t('app', 'Привязать содержимое'),
        ]);
    }
    
    /**
     * @inheritdoc
     */
    public static function find()
    {
        return (parent::find())->where(['tree' => self::MAIN_MENU]);
    }
  
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['exchange_log'] = [
            'class' => \backend\components\ExchangeLogBehavior::className(),
        ];
      
        return $behaviors;
    }
  
    public function getLinkObject()
    {
        if (!$this->entity) {
            return null;
        }

        $node = Node::findOne($this->entity);
        return $node ? $this->hasOne($node->class, ['id' => 'entity_id']) : null;
    }
}