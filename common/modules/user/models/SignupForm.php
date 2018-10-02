<?php
namespace modules\user\models;

use Yii;
use yii\base\Model;
use common\components\CompositeForm;

/**
 * Signup form
 */
class SignupForm extends CompositeForm
{
    public $password;
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
          ['password', 'required'],
          ['password', 'string', 'min' => 6],
        ];
    }
  
    protected function internalForms()
    {
        return ['user', 'profile'];
    }

    public function __construct($config = [])
    {
        $this->user = new User(['scenario' => User::SCENARIO_CREATE]);
        $this->profile = new UserProfile(['scenario' => User::SCENARIO_CREATE]);
      
        parent::__construct($config);
    }
    
    /**
     * @inheritdoc
    */
    public function load($data, $formName = '')
    {
        return parent::load($data, $formName) && $this->user->load($data, $formName);
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function save()
    {
        if (!$this->validate()) {
            return null;
        }

        $transaction = \Yii::$app->db->beginTransaction();

        try {
            $this->user->setPassword($this->password)
                ->generateAuthKey();

            if ($this->user->save()) {
                $this->user->link('profile', $this->profile);
                
                $transaction->commit();
                return $this->user;
            }

            $transaction->rollBack();
        } catch(\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch(\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }

        return $this->user;
    }
}
