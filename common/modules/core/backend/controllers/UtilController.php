<?php

namespace common\modules\core\backend\controllers;

use Yii;
use backend\controllers\BaseController;
use yii\helpers\ArrayHelper;
use common\models\Node;

/**
 * UtilController implements the CRUD actions for User model.
 */
class UtilController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
          'ajax' => [
              'class' => \yii\filters\AjaxFilter::className(),
          ],
          'format' => [
              'class' => \yii\filters\ContentNegotiator::className(),
              'formats' => [
                  'application/json' => \yii\web\Response::FORMAT_JSON
              ],
            ]
        ]);
    }
  
    public function actions()
    {
        return [
          'node-list-json' => [
              'class' => \kartik\depdrop\DepDropAction::className(),
              'outputCallback' => function ($selectedId, $params) {
                  $node = Node::findOne($selectedId);

                  return $node ? ArrayHelper::toArray($node->class::find()->All(), [
                    $node->class => ['id', 'name' => 'title']
                  ]) : [];
              }
          ]
        ];
    }
}