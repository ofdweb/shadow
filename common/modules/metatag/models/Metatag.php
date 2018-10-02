<?php

namespace modules\metatag\models;

use Yii;

/**
 * This is the model class for table "metatag".
 *
 * @property string $entity
 * @property int $entity_id
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property string $abstract
 */
class Metatag extends \common\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'metatag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['entity', 'title'], 'required'],
            ['entity_id', 'required', 'when' => function($model) {
                return !$model->isNewRecord;
            }],
            [['entity_id'], 'integer'],
            [['description', 'abstract'], 'string'],
            [['entity'], 'string', 'max' => 32],
            [['title', 'keywords'], 'string', 'max' => 64],
            [['entity', 'entity_id'], 'unique', 'targetAttribute' => ['entity', 'entity_id']],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'entity' => Yii::t('app', 'Entity'),
            'entity_id' => Yii::t('app', 'Entity ID'),
            'title' => Yii::t('app', 'Заголовок'),
            'keywords' => Yii::t('app', 'Ключевые слова'),
            'description' => Yii::t('app', 'Описание'),
            'abstract' => Yii::t('app', 'Аннотация'),
        ];
    }
}
