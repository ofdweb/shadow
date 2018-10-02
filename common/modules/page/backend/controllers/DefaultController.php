<?php

namespace common\modules\page\backend\controllers;

use Yii;
use backend\controllers\BaseController;

/**
 * DefaultController implements the CRUD actions for Page model.
 */
class DefaultController extends BaseController
{
    public $searchModelClass = 'modules\page\backend\models\PageSearch';
  
    public $modelClass = 'modules\page\backend\models\Page';

    public function findModel($id)
    {
        $class = $this->modelClass;
        return $class::find()
            ->with(['metatag', 'images', 'tags', 'menu', 'status'])
            ->joinWith(['created', 'updated as upd'])
            ->byId($id);
    }
}
