<?php

namespace common\modules\menu\backend\controllers;

use Yii;
use backend\controllers\BaseController;

/**
 * DefaultController implements the CRUD actions for Article model.
 */
class MainController extends BaseController
{
    public $modelClass = 'modules\menu\backend\models\MainMenu';
  
    public $employeeService = 'common\modules\menu\backend\controllers\services\MenuService';
  
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);

        return array_merge($actions, [
            'moveNode' => [
                'class' => 'voskobovich\tree\manager\actions\MoveNodeAction',
                'modelClass' => $this->modelClass,
            ]
        ]);
    }
  
    /**
     * Lists all Menu models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = \backend\controllers\actions\IndexBaseAction::$layout;
      
        return $this->render('index', [
            'modelClass' => $this->modelClass,
        ]);
    }
  
    /*public function findModel($id)
    {
        $model = $this->modelClass::find()
          ->with(['parent'])
          ->byId($id); dd($model);
    }*/
}