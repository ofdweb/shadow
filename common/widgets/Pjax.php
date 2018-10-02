<?php
namespace common\widgets;

use Yii;
use yii\helpers\Html;

class Pjax extends \yii\widgets\Pjax
{
    public $timeout = false;
  
    public $isGrid = false;
  
    public $isForm = false;
    
    public $render = false;

     /**
     * {@inheritdoc}
     */
    public function init()
    {
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
      
        if ($this->isForm) {
          $this->enablePushState = false;
          $this->formSelector = false;
          $this->linkSelector = false;
        }

        if ($this->isGrid) {
          $linkSelector = '#' . $this->options['id'] . ' a[data-sort], #' . $this->options['id'] . ' a[data-method]';
          $this->linkSelector = $this->linkSelector ? ($this->linkSelector . ',' . $linkSelector) : $linkSelector;
        }
      
        parent::init();
    }
}
