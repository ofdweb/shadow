<?php

namespace common\modules\article\frontend\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use modules\article\frontend\models\Article;

/**
 * DefaultController implements the CRUD actions for Page model.
 */
class DefaultController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $provider = new ActiveDataProvider([
            'query' => Article::itemListProvider(),
        ]);

        return Yii::$app->request->isPjax ? $this->renderAjax('_index_pjax', compact('provider')) : $this->render('index', compact('provider'));
    }
}
