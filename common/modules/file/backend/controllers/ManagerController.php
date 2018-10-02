<?php

namespace common\modules\file\backend\controllers;

use Yii;
use backend\controllers\BaseController;
use modules\file\components\FileObject;

class ManagerController extends BaseController
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
          'ajax' => [
              'class' => \yii\filters\AjaxFilter::className(),
             // 'only' => ['unlink'],
          ],
          'verbs' => [
              'class' => \yii\filters\VerbFilter::className(),
              'actions' => [
                  'unlink'  => ['DELETE'],
                  'sort' => ['POST'],
                  'inline-upload' => ['POST', 'GET']
              ],
          ],
          'format' => [
              'class' => \yii\filters\ContentNegotiator::className(),
              'formats' => [
                  'application/json' => \yii\web\Response::FORMAT_JSON
              ],
            ]
        ]);
    }
  
    public function beforeAction($action) 
    {
        $this->enableCsrfValidation = ($action->id !== "inline-upload"); 
        return parent::beforeAction($action);
    }
  
    public function actionUnlink()
    {
        list('class' => $entityClass, 'id' => $entityId, 'fid' => $fid, 'attribute' => $behavior) = Yii::$app->request->post() + ['class' => null, 'id' => 0, 'fid' => 0, 'attribute' => null];

        if ($entityClass) {
          $entityModel = $entityClass::find()->byId($entityId);

          if ($entityModel && $entityModel->getBehavior($behavior)) {
            $entityModel->getBehavior($behavior)->unlink($fid);
          }
        }
        
    }
  
    public function actionSort()
    {
        list('class' => $entityClass, 'id' => $entityId, 'list' => $sortList, 'attribute' => $attribute) = Yii::$app->request->post() + ['class' => null, 'id' => 0, 'list' => [], 'attribute' => null];

        if ($entityClass) {
          $command = Yii::$app->db->createCommand();
          $formName = $entityClass::instance()->formName();
          
          foreach ($sortList as $el) {
            $command->update('file_usage', [
              'weight' => $el['weight']
            ], [
              'fid' => $el['fid'],
              'entity' => $formName,
              'type' => $attribute
            ])->execute();
          }
        }
    }
  
    public function actionInlineUpload()
    {
        $uploadFiles = FileObject::getInstancesByName('file');

        if (!$uploadFiles) {
          return [];
        }
      
        foreach ($uploadFiles as $key => $file) {
            $file->setUri('inline')
              ->upload()
              ->createThumb('ThumbStyle');

            if (!$file->error) {
                $result['file-' . $key] = [
                    'url' => $file->src,
                    'id' => $key
                ];
            }
        }
      
        return $result;
    }
  
    public function actionImageList()
    {
        $fileManager = Yii::$app->getModule('file')->manager;
        $files = $fileManager->remoteDir('inline')->typeImg()->list();
        
        if (!$files) {
          return [];
        }
        
        foreach ($files as $key => $file) {
            $result['file-' . $key] = [
                'url' => $file->src,
                'thumb' => $file->thumbSrc('ThumbStyle'),
                'id' => $key
            ];
        }
        
        return $result;
    }
}
