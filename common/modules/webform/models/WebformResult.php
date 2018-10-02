<?php

namespace modules\webform\models;

use Yii;

/**
 * This is the model class for table "webform_result".
 *
 * @property int $id
 * @property int $form_id
 * @property int $delivery_id
 * @property array $result
 * @property int $created_at
 * @property int $created_by
 *
 * @property Webform $form
 */
class WebformResult extends \common\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'webform_result';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['form_id'], 'required'],
            [['form_id', 'delivery_id', 'created_at', 'created_by'], 'integer'],
            [['result'], 'safe'],
            [['form_id'], 'exist', 'skipOnError' => true, 'targetClass' => Webform::className(), 'targetAttribute' => ['form_id' => 'id']],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'form_id' => Yii::t('app', 'Форма'),
            'delivery_id' => Yii::t('app', 'Сообщение'),
            'result' => Yii::t('app', 'Результат'),
            'created_at' => Yii::t('app', 'Создано'),
            'updated_at' => Yii::t('app', 'Обновлено'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForm()
    {
        return $this->hasOne(Webform::className(), ['id' => 'form_id']);
    }
}
