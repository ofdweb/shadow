<?php
namespace modules\user\models;

use Yii;
use yii\base\NotSupportedException;
use common\db\ActiveRecord;
use yii\web\IdentityInterface;
use common\modules\rbac\models\AuthItem;
use common\modules\rbac\models\AuthAssignment;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => self::class],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => self::class],
        ]);
    }
  
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'Логин'),
            'email' => Yii::t('app', 'Email'),
            'status_id' => Yii::t('app', 'Статус'),
            'created_at' => Yii::t('app', 'Создано'),
            'updated_at' => Yii::t('app', 'Обновлено'),
            'created_by' => Yii::t('app', 'Автор'),
            'updated_by' => Yii::t('app', 'Обновил'),
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['user'] = \modules\user\behaviors\UserBehavior::className();
        
        return $behaviors;
    }
  
    /**
     * @inheritdoc
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }
    
    public function getProfile()
    {
        return $this->hasOne(UserProfile::className(), ['user_id' => 'id']);
    }
  
    public function getRoles()
    {
      return $this->hasMany(AuthItem::className(), ['name' => 'item_name'])
              ->viaTable(AuthAssignment::tableName(), ['user_id' => 'id'])
              ->onCondition([AuthItem::tableName() . '.type' => AuthItem::TYPE_ROLE]);
    }
    
    public function setProfile($data)
    {
        return $this->profile = $data;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::find()->active()->joinWith('profile')->byId($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::find()->byParams(['username' => $username])->active()->joinWith('profile')->one();
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::find()->byParams([
            'password_reset_token' => $token
        ])->active()->one();
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }
    
    public function getFullName()
    {
        return ($this->profile && $this->profile->hasName) ? 
          trim(implode(' ', [
            $this->profile->surname,
            $this->profile->firstname,
            $this->profile->lastname
          ])) : Yii::$app->formatter->nullDisplay;
    }
  
    public function getShortName()
    {
        return ($this->profile && $this->profile->hasName) ? 
          trim(implode(' ', [
            $this->profile->surname,
            $this->profile->firstname ? (mb_substr($this->profile->firstname, 0, 1) . '.') : null,
            $this->profile->lastname ? (mb_substr($this->profile->lastname, 0, 1) . '.') : null
          ])) : Yii::$app->formatter->nullDisplay;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
        return $this;
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
    
    public function assignRole($roleName)
    {
        if (!$this->isNewRecord) {
            $manager = Yii::$app->authManager;
            $role = $manager->getRole($roleName);
            
            if ($role) {
                $manager->assign($role, $this->id);
            }    
        }
    }
}
