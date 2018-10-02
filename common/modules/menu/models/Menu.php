<?php

namespace modules\menu\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "menu".
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property int $status_id
 * @property int $tree
 * @property int $lft
 * @property int $rgt
 * @property int $depth
 * @property string $entity
 * @property int $entity_id
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property User $createdBy
 * @property User $updatedBy
 */
class Menu extends \common\db\ActiveRecord
{  
    const MAIN_MENU = 1;
    
    const CATALOG_MENU = 2;
    
    public $parent_id;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }
  
    /**
     * @inheritdoc
     */
    public static function find()
    {
        return new MenuQuery(get_called_class());
    }
    
    public function attributes()
    {
        return array_merge(parent::attributes(), [
            'parent_id'
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['status_id', 'tree', 'lft', 'rgt', 'depth', 'entity_id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'parent_id'], 'integer'],
            [['title', 'slug'], 'string', 'max' => 255],
            [['entity'], 'string', 'max' => 32],
            
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Название ссылки меню'),
            'slug' => Yii::t('app', 'Синоним URL'),
            'status_id' => Yii::t('app', 'Статус'),
            'tree' => Yii::t('app', 'Меню'),
            'lft' => Yii::t('app', 'Lft'),
            'rgt' => Yii::t('app', 'Rgt'),
            'depth' => Yii::t('app', 'Depth'),
            'entity' => Yii::t('app', 'Содержимое'),
            'entity_id' => Yii::t('app', 'Материал'),
            'created_at' => Yii::t('app', 'Создано'),
            'updated_at' => Yii::t('app', 'Обновлено'),
            'created_by' => Yii::t('app', 'Автор'),
            'updated_by' => Yii::t('app', 'Обновил'),
            'parent_id' => Yii::t('app', 'Родитель'),
        ];
    }
  
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['nested'] = [
          'class' => \paulzi\nestedintervals\NestedIntervalsBehavior::className(),
          'treeAttribute' => 'tree',
        ];
      
        return $behaviors;
    }
    
    /**
     * @inheritdoc
     */
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }
  
    public function getHasEntity()
    {
        return $this->entity && $this->entity_id;
    }
    
    public function dropDownList($options = [null, true])
    {
        $model = call_user_func_array([self::findOne(['tree' => $this->root->tree]), 'getDescendants'], $options);
      
        $result = ArrayHelper::map($model->all(), 'id', function($data) {
          return $data->depth ? (str_repeat("-", $data->depth) . $data->title) : ('<' . $data->title . '>');
        });
      
        if (!$this->isNewRecord) {
          unset($result[$this->id]);
        }

        return $result;
    }
  
    public static function itemTree($tree, $depth = 1)
    {
        return self::find()->where(['tree' => $tree, 'depth' => $depth])->orderBy(['lft' => SORT_ASC])->all();
    }
}
