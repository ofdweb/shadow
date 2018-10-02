<?php

namespace common\modules\article\backend\controllers;

use Yii;
use backend\controllers\BaseController;

/**
 * DefaultController implements the CRUD actions for Article model.
 */
class DefaultController extends BaseController
{
    public $searchModelClass = 'modules\article\backend\models\ArticleSearch';
  
    public $modelClass = 'modules\article\backend\models\Article';
  
    public function findModel($id)
    {
        return $this->modelClass::find()
            ->with(['images', 'metatag', 'tags', 'status'])
            ->joinWith(['created', 'updated as upd'])
            ->byId($id);
    }
}
