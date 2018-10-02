<?php

namespace common\modules\product\frontend\controllers;

use Yii;
use modules\menu\frontend\models\CatalogMenu;
use modules\product\frontend\models\Product;

/**
 * CatalogController implements the CRUD actions for Page model.
 */
class CatalogController extends \yii\web\Controller
{
    public function actionView($slug)
    {
        $model = CatalogMenu::itemBySlug($slug);
        return Yii::$app->request->isPjax ? $this->renderAjax('_product_block', compact('model')) : $this->render('_product_block', compact('model'));
    }
    
    public function actionItems($slug)
    {
        $model = CatalogMenu::itemBySlug($slug);
        $product = Product::find()->byParams()->joinWith('images', true, 'RIGHT JOIN')->active()->All();
        return Yii::$app->request->isPjax ? $this->renderAjax('_product_block_items', compact('model', 'product')) : $this->render('_product_block_items', compact('model', 'product'));
    }
}
