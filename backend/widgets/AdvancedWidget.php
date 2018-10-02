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

class AdvancedWidget extends Widget
{
    public $items = [
      ['core', 'InfoAdvanced'],
      ['core', 'PublishAdvanced'],
      ['core', 'SlugAdvanced'],
      ['core', 'AuthorAdvanced']
    ];

    public $append = [];
  
    public $except = [];
  
    public $model;
    
    /**
     * Renders the widget.
     */
    public function run()
    {
        $this->setItems();
        ArrayHelper::multisort($this->items, 'weight');
          
        echo $this->render('advanced', [
          'model' => $this->model,
          'items' => $this->items
        ]);
    }
  
    private function setItems()
    {
        if ($this->append) {
            $this->items = array_merge($this->items, $this->append);
        }
      
        if ($this->except) {
            $this->items = array_udiff ($this->items, $this->except, function ($a, $b) {
              return ($a[0] === $b[0] && $a[1] === $b[1]) ? 0 : -1;
            });
        }

        foreach ($this->items as $key => $advanced) {
          $advanced = is_object($advanced) ? $advanced : $this->createObject($advanced);
          
          if ($advanced && $advanced->enabled($this->model) && Yii::$app->getModule($advanced->module)) {
            $this->items[$key] = $advanced;
          } else {
            unset($this->items[$key]);
          }
        }
    }
  
    private function createObject($data)
    {
        if (!is_array($data)) {
          return null;
        }
      
        list($module, $component, $options) = $data + [null, null, []];
        $class = '\\modules\\' . $module . '\\backend\\components\\' . $component;
      
        return class_exists($class) ? Yii::createObject(array_merge(['class' => $class], $options)) : null;
    }
}