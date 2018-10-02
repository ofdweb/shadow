<?php

namespace modules\tag\models;

use Yii;

/**
 * This is the model class for table "tag".
 *
 * @property int $id
 * @property string $title
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property User $createdBy
 * @property User $updatedBy
 * @property TagRelation[] $tagRelations
 */
class Tag extends \common\db\ActiveRecord
{
    const TYPE_DEFAULT = 0;
    
    const TYPE_OPTION_PRODUCT = 10;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['created_at', 'updated_at', 'created_by', 'updated_by', 'type'], 'integer'],
            [['title'], 'string', 'max' => 64],
            ['type', 'in', 'range' => [self::TYPE_DEFAULT, self::TYPE_OPTION_PRODUCT]]
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Заголовок'),
            'created_at' => Yii::t('app', 'Создано'),
            'updated_at' => Yii::t('app', 'Обновлено'),
            'created_by' => Yii::t('app', 'Автор'),
            'updated_by' => Yii::t('app', 'Обновил'),
        ];
    }
}
