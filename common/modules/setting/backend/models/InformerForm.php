<?php

namespace modules\setting\backend\models;

use Yii;
use yii\base\Model;

class InformerForm extends Model
{
    public $ya_metrik;

    public $ga;
    
    public $chat;
  
    public $callback;

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['ya_metrik', 'ga'], 'string', 'max' => 20],
            [['chat', 'callback'], 'string'],
          
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'chat' => Yii::t('app', 'Онлайн-консультант'),
            'callback' => Yii::t('app', 'Обратный звонок'),
            'ga' => Yii::t('app', 'Google Analytics'),
            'ya_metrik' => Yii::t('app', 'Яндекс.Метрика'),
        ];
    }
}