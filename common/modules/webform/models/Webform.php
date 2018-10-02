<?php

namespace modules\webform\models;

use Yii;

/**
 * This is the model class for table "webform".
 *
 * @property int $id
 * @property string $mailer_component
 * @property string $from_email
 * @property string $from_name
 * @property string $subject
 * @property string $body
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property WebformResult $id0
 */
class Webform extends \common\db\ActiveRecord
{
    const DEFAULT_MAILER = 'mailer';
  
    const FORM_CONTACTS = 1;
  
    const FORM_CALLBACK = 2;
  
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'webform';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['subject', 'title'], 'required'],
            [['body'], 'string'],
            [['created_at', 'updated_at', 'created_by', 'updated_by', 'status_id'], 'integer'],
            [['mailer_component', 'from_email', 'to_email'], 'string', 'max' => 32],
            [['from_email', 'to_email'], 'email'],
            [['from_name', 'subject', 'title'], 'string', 'max' => 64],
            ['mailer_component', 'default', 'value' => self::DEFAULT_MAILER]
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Заголовок'),
            'mailer_component' => Yii::t('app', 'Почтовик'),
            'from_email' => Yii::t('app', 'Email отправителя'),
            'from_name' => Yii::t('app', 'Имя отправителя'),
            'to_email' => Yii::t('app', 'Email получателя'),
            'subject' => Yii::t('app', 'Тема'),
            'status_id' => Yii::t('app', 'Статус'),
            'body' => Yii::t('app', 'Текст письма'),
            'created_at' => Yii::t('app', 'Создано'),
            'updated_at' => Yii::t('app', 'Обновлено'),
            'created_by' => Yii::t('app', 'Автор'),
            'updated_by' => Yii::t('app', 'Обновил'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResults()
    {
        return $this->hasMany(WebformResult::className(), ['form_id' => 'id']);
    }
  
    public function getIsFromSystem()
    {
        return !$this->from_email && !$this->from_name;
    }
  
    public function getIsToSystem()
    {
        return !$this->to_email;
    }
  
    public function getFromName()
    {
        return $this->isFromSystem ? Yii::$app->settings->get('system', 'app_name') : $this->from_name;
    }
  
    public function getFromEmail()
    {
        return $this->isFromSystem ? Yii::$app->settings->get('system', 'app_email') : $this->from_email;
    }
  
    public function getToEmail()
    {
        return $this->isToSystem ? Yii::$app->settings->get('system', 'app_email') : $this->to_email;
    }
}
