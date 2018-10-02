<?php
namespace backend\controllers\actions;

use Yii;
use yii\base\Action;

class BaseAction extends Action
{
    public $modelClass;
  
    public $employeeService;
  
    public $view;
  
    static public $layout;
    
    public function init()
    {
        $this->employeeService = Yii::createObject($this->employeeService, [$this->modelClass]);
        $this->controller->layout = static::$layout;
      
        parent::init();
    }
  
    public function redirect($view, $id = null)
    {
        $actions = $this->controller->actions();
        $method = 'action' . ucFirst($view);

        if (!isset($actions[$view]) && !$this->controller->hasMethod($method)) {
          return $this->controller->refresh();
        }
      
        $url = $id ? [$view, 'id' => $id] : $view;
        return $this->controller->redirect($url) ;
    }
}