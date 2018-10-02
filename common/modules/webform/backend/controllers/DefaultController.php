<?php

namespace common\modules\webform\backend\controllers;

use Yii;
use backend\controllers\BaseController;
use modules\webform\models\Webform;

/**
 * DefaultController implements the CRUD actions for Page model.
 */
class DefaultController extends BaseController
{
    public $modelClass = 'modules\webform\backend\models\Webform';
  
    public $searchModelClass = 'modules\webform\backend\models\WebformResultSearch';
  
    public function actions()
    {
        return [
          'form' => [
            'class' => 'backend\controllers\actions\UpdateBaseAction',
            'modelClass' => $this->modelClass,
            'employeeService' => $this->employeeService,
            'view' => 'form'
          ],
          'result' => [
            'class' => 'backend\controllers\actions\IndexBaseAction',
            'modelClass' => $this->searchModelClass,
            'employeeService' => $this->employeeService,
            'view' => 'result'
          ]
        ];
    }
}
