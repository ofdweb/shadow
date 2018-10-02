<?php

namespace modules\page\models;

use Yii;
use common\db\MultilingualQuery;
use modules\file\models\FileManaged;

/**
 * This is the model class for table "page".
 *
 * @property int $id
 * @property string $slug
 * @property int $status_id
 * @property int $created_at
 * @property int $updated_at
 * @property string $published_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property User $createdBy
 * @property User $updatedBy
 * @property PageLang[] $pageLangs
 */
class Page extends \common\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['title'], 'required'],
            [['status_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['published_at', 'description'], 'safe'],
            [['slug'], 'string', 'max' => 255],
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
            'description' => Yii::t('app', 'Описание'),
            'slug' => Yii::t('app', 'Синоним URL'),
            'status_id' => Yii::t('app', 'Статус'),
            'created_at' => Yii::t('app', 'Создано'),
            'updated_at' => Yii::t('app', 'Обновлено'),
            'created_by' => Yii::t('app', 'Автор'),
            'updated_by' => Yii::t('app', 'Обновил'),
            'published_at' => Yii::t('app', 'Опубликованно'),
        ];
    }
  
    /**
     * @inheritdoc
     */
    public static function find()
    {
        return (new MultilingualQuery(get_called_class()))->multilingual();
    }
  
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
      
        $behaviors['translations'] = [
          'class' => \omgdef\multilingual\MultilingualBehavior::className(),
          'languages' => [
            'ru' => 'Russian',
            'en-US' => 'English',
          ],
          'langForeignKey' => 'entity_id',
          'tableName' => "{{%page_lang}}",
          'attributes' => [
            'title', 'description',
           ]
        ];
      
        return $behaviors;
    }
  
    public function getImages()
    {
        return $this->hasMany(FileManaged::className(), ['id' => 'fid'])
            ->viaTable('file_usage', ['entity_id' => 'id'], function($query) {
                $query->onCondition(['file_usage.entity' => $this->formName(), 'file_usage.type' => 'files']);
            })
            ->join('INNER JOIN', 'file_usage AS fu', 'fu.fid = ' . FileManaged::tableName() . '.id')
            ->orderBy(['fu.weight' => SORT_ASC]);
    }
}
