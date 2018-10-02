<?php

namespace modules\user\models;

use Yii;
use modules\file\models\FileManaged;

/**
 * This is the model class for table "profiles".
 *
 * @property int $user_id
 * @property string $firstname
 * @property string $surname
 * @property string $lastname
 * @property string $note
 * @property int $last_vizit_at
 * @property int $image_id
 *
 * @property User $user
 */
class UserProfile extends \common\db\ActiveRecord
{
    public $image;
  
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['user_id'], 'required', 'on' => self::SCENARIO_DEFAULT],
            [['user_id', 'last_vizit_at'], 'integer'],
            [['note'], 'string'],
            [['firstname', 'surname', 'lastname'], 'string', 'max' => 32],
            [['user_id'], 'unique'],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('app', 'Пользователь'),
            'firstname' => Yii::t('app', 'Имя'),
            'surname' => Yii::t('app', 'Фамилия'),
            'lastname' => Yii::t('app', 'Отчество'),
            'note' => Yii::t('app', 'Примечание'),
            'last_vizit_at' => Yii::t('app', 'Последнее посещение'),
            'image' => Yii::t('app', 'Изображение'),
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
      
        $behaviors['image'] = [
          'class' => \modules\file\behaviors\FileBehavior::className(),
          'relation' => 'avatar',
          'attribute' => 'image'
        ];
        
        return $behaviors;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
  
    public function getAvatar()
    {
        return $this->hasOne(FileManaged::className(), ['id' => 'fid'])
            ->viaTable('file_usage', ['entity_id' => 'user_id'], function($query) {
                $query->onCondition(['entity' => $this->formName(), 'type' => 'avatar']);
            });
    }

    public function updateLastVizit($event)
    {
        self::updateAll(['last_vizit_at' => Yii::$app->formatter->asTimestamp('NOW')], ['user_id' => $event->sender->id]);
    }

    public function getHasName()
    {
        return $this->surname || $this->firstname || $this->lastname;
    }
  
    public function getAvatarThumb()
    {
        return $this->avatar ? $this->avatar->thumb : '@theme_asset/img/user.ico';
    }
}
