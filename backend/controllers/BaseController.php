<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Base controller
 */
abstract class BaseController extends Controller
{
    public $modelClass;
  
    public $searchModelClass;
  
    public $employeeService = 'backend\controllers\services\EmployeeService';
  
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => '\yii\filters\VerbFilter',
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
  
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return $this->modelClass ? [
            'index' => [
                'class' => 'backend\controllers\actions\IndexBaseAction',
                'modelClass' => $this->searchModelClass,
                'employeeService' => $this->employeeService
            ],
            'create' => [
                'class' => 'backend\controllers\actions\CreateBaseAction',
                'modelClass' => $this->modelClass,
                'employeeService' => $this->employeeService
            ],
            'update' => [
                'class' => 'backend\controllers\actions\UpdateBaseAction',
                'modelClass' => $this->modelClass,
                'employeeService' => $this->employeeService
            ],
            'view' => [
                'class' => 'backend\controllers\actions\ViewBaseAction',
                'modelClass' => $this->modelClass,
                'employeeService' => $this->employeeService
            ],
            'delete' => [
                'class' => 'backend\controllers\actions\DeleteBaseAction',
                'modelClass' => $this->modelClass,
                'employeeService' => $this->employeeService
            ],
        ] : [];
    }

    public function goNotFound()
    {
        throw new NotFoundHttpException(Yii::t('app', 'Страница не существует'));
    }
/*
    public function render($view, $params = [])
    { 
        if (!Yii::$app->request->isPjax) {
          return parent::render($view, $params);
        }
      
        if (Yii::$app->request->headers->get('x-pjax-container') != '#content-wrapper') {
          return $this->renderAjax($view, $params);
        }
        
        return parent::render($view, $params);
        //$content = $this->renderAjax($view, $params);
      
        //return $this->renderPartial('@theme/views/layouts/_before-content') . $content . $this->renderPartial('@theme/views/layouts/_after-content');
    }*/
}