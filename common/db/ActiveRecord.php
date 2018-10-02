<?php

namespace common\db;

use common\models\Status;
use modules\user\models\User;
use common\models\Node;
//use common\modules\logger\models\Log;

class ActiveRecord extends \yii\db\ActiveRecord 
{
    const SCENARIO_CREATE = 'create';
  
    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
      
        if ($this->hasAttribute('created_by')) {
          $rules = array_merge($rules, [
              [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id'], 'when' => function($model) {
                return $model->isNewRecord;
              }] ,
              [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
              [['created_by', 'updated_by'], 'filter', 'filter' => function ($value) {
                  return (int)$value;
              }],
          ]);
        }

        if ($this->hasAttribute('status_id')) {
          $rules = array_merge($rules, [
              ['status_id', 'default', 'value' => Status::ACTIVE],
              ['status_id', 'in', 'range' => array_keys(self::statusList())],
              [['status_id'], 'filter', 'filter' => function ($value) {
                  return (int)$value;
              }],
          ]);
        }

       /* if ($this->hasAttribute('entity')) {
          $rules = array_merge($rules, [
              [['entity'], 'in', 'range' => array_keys(Node::itemList())]
          ]);
        }*/
      
        return $rules;
    }
  
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = $scenarios[self::SCENARIO_DEFAULT];
        return $scenarios;
    }
  
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
      
        if ($this->hasAttribute('created_at')) {
          $behaviors['timestamp'] = [
            'class' => \yii\behaviors\TimestampBehavior::className(),
            'createdAtAttribute' => 'created_at',
            'updatedAtAttribute' => 'updated_at',
            'value' => \Yii::$app->formatter->asTimestamp('NOW'),
          ];
        }
      
        if ($this->hasAttribute('created_by')) {
          $behaviors['blameable'] = [
              'class' => \yii\behaviors\BlameableBehavior::className(),
              'createdByAttribute' => 'created_by',
              'updatedByAttribute' => 'updated_by'
          ];
        }
      
        /*if ($this->hasAttribute('is_deleted')) {
          $behaviors['delete'] = [
              'class' => \yii2tech\ar\softdelete\SoftDeleteBehavior::className(),
              'softDeleteAttributeValues' => [
                  'is_deleted' => Status::DELETED
               ],
           ];
        }*/

        return $behaviors;
    }
  
    /**
     * @inheritdoc
     */
    public static function find()
    {
        return new BaseQuery(get_called_class());
    }
   
    public function getCreated()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
  
    public function getUpdated()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }
  
    public function getStatus()
    {
        return $this->hasOne(Status::className(), ['id' => 'status_id']);
    }
  
    public static function statusList()
    {
        return Status::defaultList();
    }
}