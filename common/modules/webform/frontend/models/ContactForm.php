<?php

namespace modules\webform\frontend\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\base\Model as BaseModel;
use modules\webform\models\Webform;

class ContactForm extends BaseModel
{
    public $name;
  
    public $body;
  
    public $phone;
  
    protected $_mailer;
  
    protected $_webform;
  
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'phone', 'body'], 'safe']
        ];
    }
  
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Ваше имя'),
            'phone' => Yii::t('app', 'Ваш телефон'),
            'body' => Yii::t('app', 'Сообщение')
        ];
    }
  
    public function tokens()
    {
        return [
          [
            'attribute' => 'form_name',
            'label' => Yii::t('app', 'Имя отправителя'),
            'value' => $this->name
          ], [
            'attribute' => 'form_phone',
            'label' => Yii::t('app', 'Телефон отправителя'),
            'value' => $this->phone
          ], [
            'attribute' => 'form_text',
            'label' => Yii::t('app', 'Сообщение отправителя'),
            'value' => $this->body
          ]
        ];
    }
  
    protected function getWebform()
    {
      if (!$this->_webform) {
        $this->_webform = Webform::find()->byId(Webform::FORM_CONTACTS);
      }
      return $this->_webform;
    }
  
    protected function getMailer()
    {
        if (!$this->_mailer) {
          $this->_mailer = Yii::$app->get($this->webform->mailer_component);
        }
        return $this->_mailer;
    }
  
    protected function getComposeBody()
    {
      return \App::t($this->webform->body, ArrayHelper::map($this->tokens(), 'attribute', 'value'));
    }
  
    public function send()
    {
       return $this->mailer->compose()
          ->setFrom([$this->webform->fromEmail => $this->webform->fromName])
          ->setTo($this->webform->toEmail)
          ->setSubject($this->webform->subject)
          ->setHtmlBody($this->composeBody)
          ->send();
    }
}