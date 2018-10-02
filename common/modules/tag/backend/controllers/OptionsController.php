<?php

namespace common\modules\tag\backend\controllers;

use Yii;
use backend\controllers\BaseController;

/**
 * OptionsController implements the CRUD actions for User model.
 */
class OptionsController extends BaseController
{
    public $searchModelClass = 'modules\tag\backend\models\ProductOptionSearch';
  
    public $modelClass = 'modules\tag\backend\models\ProductOption';

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function findModel($id)
    {
        return $this->modelClass::find()
          ->joinWith(['created', 'updated as upd'])
          ->byId($id);
    }
}
