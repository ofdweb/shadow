<?php

namespace common\modules\tag\backend\controllers;

use Yii;
use backend\controllers\BaseController;

/**
 * DefaultController implements the CRUD actions for User model.
 */
class DefaultController extends BaseController
{
    public $searchModelClass = 'modules\tag\backend\models\TagSearch';
  
    public $modelClass = 'modules\tag\backend\models\Tag';

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
