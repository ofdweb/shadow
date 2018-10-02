<?php
namespace common\models;

use common\components\CompositeForm;

/**
 * Node form
 */
abstract class NodeForm extends CompositeForm
{
    /**
     * {@inheritdoc}
     */
    protected function internalForms()
    {
        return ['user', 'profile'];
    }
    
    /**
     * {@inheritdoc}
     */
    public function __construct($config = [])
    {
        $this->user = new User(['scenario' => User::SCENARIO_CREATE]);
        $this->profile = new UserProfile(['scenario' => User::SCENARIO_CREATE]);
      
        parent::__construct($config);
    }
}