<?php

namespace common\modules\page\frontend\controllers;

use Yii;
use modules\page\frontend\models\Page;

/**
 * DefaultController implements the CRUD actions for Page model.
 */
class DefaultController extends \yii\web\Controller
{
    public function actionHome()
    {
        $this->layout = 'main_home';
        $model = Page::itemById(\App::$pageId);
      
        return $this->render('index', compact('model'));
    }
  
    public function actionView($slug)
    {
        $model = Page::itemBySlug($slug);
        return Yii::$app->request->isPjax ? $this->renderAjax('_page_block', compact('model')) : $this->render('view', compact('model'));
    }
  
    public function actionItems($slug)
    {
        
    }
}
