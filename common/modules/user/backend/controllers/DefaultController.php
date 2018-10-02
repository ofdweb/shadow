<?php

namespace common\modules\user\backend\controllers;

use Yii;
use backend\controllers\BaseController;
use yii\web\NotFoundHttpException;

/**
 * DefaultController implements the CRUD actions for User model.
 */
class DefaultController extends BaseController
{
    public $searchModelClass = 'modules\user\backend\models\UserSearch';
  
    public $modelClass = 'modules\user\backend\models\UserForm';
  
    public function beforeAction($action)
    {
        if($action->id == 'view') {
            $this->layout = null;
        }
        
        return true;
    }
  
    public function findModel($id)
    {
        return $this->modelClass::instance()->findUser($id);
    }
}
