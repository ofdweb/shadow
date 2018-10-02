<?php
namespace backend\controllers\actions;

use Yii;

/**
* Lists all models.
* @return mixed
*/
class IndexBaseAction extends BaseAction
{
    static public $layout = '@theme/layouts/crud/_index.php';
  
    public $view = 'index';
  
    public function run()
    {
        $searchModel = $this->modelClass::instance();
        $dataProvider = $this->employeeService->search();

        return $this->controller->render($this->view, [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}