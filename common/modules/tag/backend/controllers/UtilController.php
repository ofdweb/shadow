<?php

namespace common\modules\tag\backend\controllers;

use Yii;
use modules\tag\models\Tag;
use backend\controllers\BaseController;
use yii\helpers\ArrayHelper;

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

    public function actionListJson($q = null)
    {
        $out = ['results' => ['id' => '', 'text' => '']];
      
        if ($q) {
            $model = Tag::find()->select(['id', 'title'])
              ->byParams(['LIKE', 'title', '%' . $q . '%', false])
              ->limit(5)
              ->all();
          
            $out['results'] = ArrayHelper::toArray($model, [
                Tag::className() => ['id', 'text' => 'title']        
            ]);
        }

        return $out;
     }
}
