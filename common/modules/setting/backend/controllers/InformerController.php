<?php

namespace common\modules\setting\backend\controllers;

use Yii;
use backend\controllers\BaseController;

/**
 * InformerController implements the CRUD actions for Page model.
 */
class InformerController extends BaseController
{
    public $modelClass = 'modules\setting\backend\models\InformerForm';
  
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'index' => [
                'class' => \yii2mod\settings\actions\SettingsAction::class,
                'view' => 'index',
                'sectionName' => 'informer',
                'successMessage' => 'Настройки успешно сохранены',
                'modelClass' => $this->modelClass,
            ]
        ];
    }
  
    public function beforeAction($action)
    {
        if($action->id == 'index') {
            $this->layout = \backend\controllers\actions\UpdateBaseAction::$layout;
        }
        
        return true;
    }
}
