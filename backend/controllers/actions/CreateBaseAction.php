<?php
namespace backend\controllers\actions;

use Yii;

/**
* Lists all models.
* @return mixed
*/
class CreateBaseAction extends BaseAction
{  
    static public $layout = '@theme/layouts/crud/_update.php';
  
    public $view = 'create';
  
    public function run()
    {
        $employeeService = $this->employeeService;

        if ($employeeService->load()) {
            $employeeService->on($employeeService::EVENT_AFTER_ACTION, [$employeeService, 'saveFlashMessage']);

            if ($employeeService->save()) {
              return $this->redirect('view', $employeeService->primaryKey);
            }
        } 
        
        return $this->controller->render($this->view, [
            'model' => $employeeService->model,
        ]);
    }
}