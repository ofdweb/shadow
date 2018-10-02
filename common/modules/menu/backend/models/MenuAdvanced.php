<?php

namespace modules\menu\backend\models;

use Yii;
use modules\menu\models\Menu as BaseModel;
use yii\helpers\ArrayHelper;

class MenuAdvanced extends BaseModel
{
    public $create_link = false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['title'], 'required', 'when' => function($model) {
              return $model->create_link && !$model->isNewRecord;
            }],
            [['create_link'], 'boolean']
        ]);
    }
  
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'create_link' => Yii::t('app', 'Создать ссылку в меню'),
        ]);
    }
}