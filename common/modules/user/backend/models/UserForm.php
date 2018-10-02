<?php
namespace modules\user\backend\models;

use Yii;
use yii\base\Model;
use modules\user\models\User;
use modules\user\models\UserProfile;
use yii\helpers\ArrayHelper;

/**
 * User form
 */
class UserForm extends Model
{
    public $user;
  
    public $profile;
  
    public $roles;
  
    public $password;
  
    public $password_repeat;
  
    const SCENARIO_CREATE = 'scenarioCreate';
  
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
          [['user', 'profile'], 'required'],
          ['roles', 'each', 'rule' => ['string']],
          [['password', 'password_repeat'], 'required', 'on' => self::SCENARIO_CREATE],
          ['password', 'string', 'min' => 6, 'on' => self::SCENARIO_CREATE],
          ['password_repeat', 'compare', 'compareAttribute' => 'password', 'on' => self::SCENARIO_CREATE],
        ];
    }
  
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
          'roles' => Yii::t('app', 'Роли'),
          'password' => Yii::t('app', 'Пароль'),
          'password_repeat' => Yii::t('app', 'Подтверждение пароля'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->user = new User(['scenario' => User::SCENARIO_CREATE]);
        $this->profile = new UserProfile(['scenario' => User::SCENARIO_CREATE]);
        $this->roles = [];

        $this->setScenario(self::SCENARIO_CREATE);
      
        parent::init();
    }
    
    /**
     * @inheritdoc
    */
    public function load($data, $formName = null)
    {
        return parent::load($data, $formName) && $this->user->load($data, $formName) && $this->profile->load($data, $formName);
    }
  
    /**
     * @inheritdoc
    */
    public function afterValidate() 
    {
        $this->user->validate();
      
        if ($this->user->hasErrors()) {
            $this->addErrors($this->user->getErrors());
        }
      
        $this->profile->validate();
      
        if ($this->profile->hasErrors()) {
            $this->addErrors($this->profile->getErrors());
        }

        return parent::afterValidate();
    }
  
    public function findUser($id)
    {
        $model = $this->user::find()
          ->joinWith(['profile', 'created as crt', 'updated as upd'])
          ->with('profile.avatar')
          ->byId($id);
      
        if ($model) {
            $this->user = $model;
            $this->profile = $model->profile;
            $this->roles = ArrayHelper::getColumn(Yii::$app->authManager->getRolesByUser($id), 'name');
          
            $this->setScenario(self::SCENARIO_DEFAULT);
        }

        return $this;
    }
  
    public function getPrimaryKey()
    {
        return $this->user->id;
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function save()
    {
        if (!$this->validate()) {
            return;
        }

        $transaction = \Yii::$app->db->beginTransaction();

        try {
            $this->user->attachBehavior('exchange_log', \backend\components\ExchangeLogBehavior::className());
            $this->profile->attachBehavior('exchange_log', \backend\components\ExchangeLogBehavior::className());
          
            if ($this->isNewUser) {
                $this->user->setPassword($this->password)
                    ->generateAuthKey();
            }
          
            if ($this->user->save()) {
                $this->user->link('profile', $this->profile);
              
                Yii::$app->authManager->revokeAll($this->user->id);

                if ($this->roles) {
                  foreach ($this->roles as $roleName) {
                    $this->user->assignRole($roleName);
                  }
                }
                
                $transaction->commit();
                return true;
            } else {
                $transaction->rollBack();
            } 
        } catch(\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch(\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }

        return;
    }
  
    public function getIsNewUser()
    {
        return $this->user->isNewRecord && $this->scenario == self::SCENARIO_CREATE;
    }
}
