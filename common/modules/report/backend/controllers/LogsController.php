<?php

namespace common\modules\report\backend\controllers;

use Yii;
use backend\controllers\BaseController;
use yii\data\ActiveDataProvider;
use yii\db\Query;

/**
 * LogsController implements the CRUD actions for Page model.
 */
class LogsController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function actionExchange()
    {
        $this->layout = \backend\controllers\actions\IndexBaseAction::$layout;
      
        $query = (new Query())
          ->from('log')
          ->andFilterWhere(['LIKE', 'category', 'exchange'])
          ->orderBy(['id' => SORT_DESC]);
      
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('exchange', [
            'dataProvider' => $dataProvider
        ]);
    }
}
