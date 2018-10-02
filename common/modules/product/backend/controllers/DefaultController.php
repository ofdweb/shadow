<?php

namespace common\modules\product\backend\controllers;

use Yii;
use backend\controllers\BaseController;

/**
 * DefaultController implements the CRUD actions for Product model.
 */
class DefaultController extends BaseController
{
    public $searchModelClass = 'modules\product\backend\models\ProductSearch';
  
    public $modelClass = 'modules\product\backend\models\Product';
  
    public function findModel($id)
    {
        $class = $this->modelClass;
        return $class::find()
            ->with(['images', 'metatag', 'tags', 'status'])
            ->joinWith(['created', 'updated as upd'])
            ->byId($id);
    }
}
