<?php

namespace common\modules\report\backend\controllers;

use Yii;
use backend\controllers\BaseController;
use modules\report\backend\models\ConfigForm;

/**
 * ConfigurationController implements the CRUD actions for Page model.
 */
class ConfigurationController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function actionIndex()
    {
        $this->layout = \backend\controllers\actions\ViewBaseAction::$layout;
      
        return $this->render('index', [
            'model' => new ConfigForm(),
        ]);
    }
}
