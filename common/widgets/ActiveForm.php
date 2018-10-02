<?php

namespace common\widgets;

use yii\bootstrap\ActiveForm as BaseActiveForm;

class ActiveForm extends BaseActiveForm
{
    public function init() 
    {
        //parent::init();
        
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
    }
}