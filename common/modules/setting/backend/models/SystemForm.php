<?php

namespace modules\setting\backend\models;

use Yii;
use yii\base\Model;

class SystemForm extends Model
{
    public $app_name;

    public $app_email;
    
    public $app_slogan;
    
    public $app_worktime;
    
    public $app_phone;
    
    public $app_whatsapp;
    
    public $app_address;
    
    public $app_yamap;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['app_name', 'app_email'], 'required'],
            [['app_email'], 'email'],
            [['app_name', 'app_slogan', 'app_worktime'], 'string', 'max' => 64],
            [['app_phone', 'app_whatsapp'], 'string', 'max' => 20],
            [['app_address', 'app_yamap'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'app_name' => Yii::t('app', 'Название сайта'),
            'app_email' => Yii::t('app', 'E-mail адрес'),
            'app_slogan' => Yii::t('app', 'Слоган'),
            'app_worktime' => Yii::t('app', 'Время работы'),
            'app_phone' => Yii::t('app', 'Номер телефона'),
            'app_whatsapp' => Yii::t('app', 'WhatsApp'),
            'app_address' => Yii::t('app', 'Адрес'),
            'app_yamap' => Yii::t('app', 'Яндекс карта'),
        ];
    }
}