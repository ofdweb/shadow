<?php
namespace backend\controllers\actions;

use Yii;

/**
* Updates an existing model.
* If update is successful, the browser will be redirected to the 'view' page.
* @param integer $id
* @return mixed
*/
class UpdateBaseAction extends BaseAction
{
    static public $layout = '@theme/layouts/crud/_update.php';
  
    public $view = 'update';
  
    public $findModelCallback;
      
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