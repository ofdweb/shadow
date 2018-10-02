<?php

namespace modules\file\models;

use Yii;
use yii\helpers\Url;
use modules\file\components\FileObject;

/**
 * This is the model class for table "file_managed".
 *
 * @property int $id
 * @property string $name
 * @property string $uri
 * @property string $size
 * @property string $mime
 * @property int $status_id
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property User $createdBy
 * @property User $updatedBy
 * @property FileUsage[] $fileUsages
 */
class FileManaged extends \common\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'file_managed';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['name', 'storage'], 'required'],
            [['size', 'status_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name', 'uri'], 'string', 'max' => 255],
            [['mime', 'storage'], 'string', 'max' => 32],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'storage' => Yii::t('app', 'Storage'),
            'uri' => Yii::t('app', 'Uri'),
            'size' => Yii::t('app', 'Size'),
            'mime' => Yii::t('app', 'Mime'),
            'status_id' => Yii::t('app', 'Status ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }
  
    /**
     * @return \yii\db\ActiveQuery
     
    public function getFileUsages()
    {
        return $this->hasMany(FileUsage::className(), ['fid' => 'id']);
    }*/
  
    public function getThumb($style = 'ThumbStyle')
    {
      return FileObject::instanceManaged($this)->thumbSrc($style);
    }
  
    public function getPath()
    {
      return FileObject::instanceManaged($this)->src;
    }
}
