<?php

namespace backend\components;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\base\BaseObject;

class ContextualLink extends BaseObject
{
  public $label;
  
  public $url;
  
  private $_icon;
  
  private $_action;
  
  public $options = [];
  
  public $linkOptions = [];
  
  public $visible = true;
  
  public function init()
  {
    parent::init();
    
    $this->normalizeUrl();
    
    $this->linkOptions = array_merge([
      'data-pjax' => true
    ], $this->linkOptions);
    
    if ($this->isDeleteAction) {
      $this->linkOptions = array_merge([
        'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
        'data-method' => 'post',
      ], $this->linkOptions);
    }
    
    html::addCssClass($this->options, $this->activeClass);
  }
  
  public function getIconLabel()
  {
    return Html::fa($this->icon) . $this->label;
  }
  
  public function setIcon($value)
  {
    $this->_icon = $value;
  }
  
  public function getIcon()
  {
    if ($this->_icon) {
      return $this->_icon;
    }

    switch ($this->_action) {
      case 'index': return 'outdent'; break;
      case 'create': return 'plus '; break;
      case 'view': return 'eye'; break;
      case 'update': return 'edit '; break;
      case 'delete': return 'trash'; break;
    }
    
    return 'circle';
  }
  
  private function normalizeUrl()
  {
    if ($this->url) {
      $route = is_array ($this->url) ? explode('/', current($this->url))  : explode('/', $this->url);
      $this->_action = end($route);
    }
  }
  
  protected function getIsDeleteAction()
  {
    return $this->_action == 'delete';
  }
  
  protected function getActiveClass()
  {
    return Yii::$app->controller->action->id == $this->_action ? 'active' : null;
  }
}