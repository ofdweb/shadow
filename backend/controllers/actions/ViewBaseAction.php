<?php
namespace backend\controllers\actions;

use Yii;

/**
* Displays a single model.
* @param integer $id
* @return mixed
*/
class ViewBaseAction extends BaseAction
{
    static public $layout = '@theme/layouts/crud/_view.php';
  
    public $findModelCallback;
  
    public $view = 'view';
  
    public function run($id)
    {
        $employeeService = $this->employeeService;
      
        if ($this->findModelCallback instanceof \Closure) {
            $model = call_user_func($this->findModelCallback, $id);
        } elseif ($this->controller->hasMethod('findModel')) {
            $model = $this->controller->findModel($id);
        } else {
            $model = $employeeService->findModel($id);
        }
        
        if (!$model) {
            $this->controller->goNotFound();
        }
      
        $employeeService->setModel($model)->afterFind();
      
        return $this->controller->render($this->view, [
            'model' => $employeeService->model,
        ]);
    }
}