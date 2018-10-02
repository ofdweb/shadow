<?php

namespace common\widgets\grid\filters;

use Yii;

class StatusDropdownColumn extends DropdownColumn
{
    public $attribute = 'status_id';
  
    public function getPromptText()
    {
        return Yii::t('app', 'Статус');
    }
  
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
      
        if (!$this->items) {
          $this->items = $this->grid->filterModel::statusList();
        }
    }
}