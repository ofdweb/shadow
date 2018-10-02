<?php

namespace modules\webform\backend\models;

use Yii;
use modules\webform\models\Webform as BaseModel;

class Webform extends BaseModel
{
    public $from_system;
  
    public $to_system;
    
    public $formModel;
    
     /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->formModel = new \modules\webform\frontend\models\ContactForm();
    }
  
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['from_system', 'to_system'], 'boolean'],
            [['from_email', 'from_name'], 'required', 'when' => function($model) {
              return !$model->from_system;
            }],
            [['to_email'], 'required', 'when' => function($model) {
              return !$model->to_system;
            }],
        ]);
    }
  
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['exchange_log'] = \backend\components\ExchangeLogBehavior::className();
      
        return $behaviors;
    }
  
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'from_system' => Yii::t('app', 'Использовать глобальные настройки отправителя'),
            'to_system' => Yii::t('app', 'Использовать глобальные настройки получателя'),
        ]);
    }
  
    /**
     * {@inheritdoc}
     */
    public function afterFind()
    {
        parent::afterFind();
      
        if ($this->isFromSystem) {
          $settings = Yii::$app->settings;
          
          $this->setAttributes([
            'from_system' => true,
            'from_email' => $settings->get('system', 'app_email'),
            'from_name' => $settings->get('system', 'app_name')
          ]);
        }
      
        if ($this->isToSystem) {
          $this->setAttributes([
            'to_system' => true,
            'to_email' => Yii::$app->settings->get('system', 'app_email')
          ]);
        }
    }
  
    /**
     * {@inheritdoc}
     */
    public function beforeValidate()
    {
        if ($this->from_system) {
          $this->setAttributes([
            'from_email' => null,
            'from_name' => null
          ]);
        }
      
        if ($this->to_system) {
          $this->setAttributes([
            'to_email' => null,
          ]);
        }
      
        return parent::beforeValidate();
    }
}