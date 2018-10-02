<?php
namespace backend\controllers\actions;

use Yii;
use yii\db\IntegrityException;

/**
* Deletes an existing model.
* If deletion is successful, the browser will be redirected to the 'index' page.
* @param integer $id
* @return mixed
*/
class DeleteBaseAction extends BaseAction
{
    public function run($id)
    {
        $model = $this->modelClass::find()->byId($id);

        if (!$model) {
            $this->controller->goNotFound();
        }
      
        $employeeService = $this->employeeService;
        $employeeService->setModel($model);
      
        $employeeService->on($employeeService::EVENT_AFTER_ACTION, [$employeeService, 'deleteFlashMessage']);
      
        try {
            $employeeService->delete();
        } catch (IntegrityException $e) {
        } catch(Exception $e) {
        }
      
        return $this->redirect('index');
    }
}