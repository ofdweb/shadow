<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use backend\components\ContextualLink;

class ContextualMenuWidget extends Widget
{
    private $_items;
  
    private $_visible = false;
  
    public $label = 'Контекстное меню';
    
    /**
     * Renders the widget.
     */
    public function init()
    {
      parent::init();
      $module = Yii::$app->controller->module;
      
      if ($module->hasMethod('getContextualLinks')) {
        $this->_items = ArrayHelper::getColumn($module->contextualLinks, function ($data) {
            $link = new ContextualLink($data);
            
            if ($link->visible) {
              $this->_visible = true;
            }
            
            return ArrayHelper::toArray($link, [
              ContextualLink::class => [
                'label' => 'iconLabel',
                'url',
                'linkOptions',
                'options',
                'visible'
              ]
            ]);
          });  
      }
      
    }
  
    /**
     * Renders the widget.
     */
    public function run()
    {
      if ($this->_items && $this->_visible) {
        echo $this->render('contextual-menu', [
          'items' => $this->_items, 
          'label' => $this->label
        ]);
      }
    }

    public function getCanVisible()
    {
      return $this->_visible;
    }
}