<?php

namespace common\modules\product\frontend\controllers;

use Yii;
use modules\menu\frontend\models\CatalogMenu;
use modules\product\frontend\models\Product;

/**
 * DefaultController implements the CRUD actions for Page model.
 */
class DefaultController extends \yii\web\Controller
{
    public function actionView($slug)
    {
        $model = Product::itemBySlug($slug);
        return Yii::$app->request->isAjax ? $this->renderAjax('view_modal', compact('model')) : $this->render('view', compact('model'));
    }
}
