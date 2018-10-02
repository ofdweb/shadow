<?php

namespace common\modules\user\backend\controllers;

use Yii;
use backend\controllers\BaseController;
use yii\db\Query;
use modules\user\models\User;

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
  
    public function actionAdminListJson($q = null)
    {
        $out = ['results' => ['id' => '', 'text' => '']];
        
        if (!is_null($q)) {
            $query = new Query;
            $query->select('id, username AS text')
                ->from(User::tableName())
                ->where(['LIKE', 'username', $q])
                ->join('LEFT JOIN', 'auth_assignment', (User::tableName() . '.id = user_id'));
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }

        return $out;
     }
}