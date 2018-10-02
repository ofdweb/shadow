<?php

namespace backend\components;

use Yii;

abstract class BaseAdvanced
{
    const TYPE_COLLAPSE = 'collapse';
  
    const TYPE_BOX = 'box';
  
    public $icon;

    public $view;

    public $label;

    public $module;

    public $weight = 1;

    public $enabled = true;

    public $attributes = [];

    public $type = self::TYPE_COLLAPSE;

    public function label()
    {
      return Yii::t('app', $this->label);
    }

    public function isCollapsed($key, $model)
    {
      return ($key == 0 && !$model->hasErrors()) || $this->attributesHasErrors($model);
    }
  
    private function attributesHasErrors($model)
    {
        if (!$model->hasErrors() || !$this->attributes) {
          return;
        }
      
        foreach ($this->attributes as $attribute) {
          if ($model->hasProperty($attribute) && $model->hasErrors($attribute)) {
              return true;
          }
        }
      
        return;
    }

    public function viewPath()
    {
      return  '@modules/' . $this->module . '/backend/components/views/' . $this->view;
    }

    public function enabled($model)
    {
      return $this->enabled;
    }
}