<?php

namespace common\modules\file\controllers;

use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\helpers\Json;

/**
 * Default controller for the `file` module
 */
class ManagerController extends Controller
{

    public function actionUpload()
    {
        $files = UploadedFile::getInstancesByName('file');
      
        if ($files) {
          $fileManaged = Yii::$app->getModule('file')->manager;
          
          try {
            foreach ($files as $file) {
                $modelFile = $fileManaged->setFile($file)->save();

                if ($modelFile) {
                    $model->link($this->relation, $modelFile, $linkData);
                      //dd($modelFile->save());
                    }
                }

                $transaction->commit();
          } catch (Exception $ex) {
              $transaction->rollback();
              throw $ex;
          }
        }
      
        
      
        if ($imageFile) {
            $uid = uniqid(time(), true);
            $fileName = $uid . '.' . $imageFile->extension;
            $filePath = $directory . $fileName;
            if ($imageFile->saveAs($filePath)) {
                $path = Yii::getAlias('@files/temp') . Yii::$app->session->id . DIRECTORY_SEPARATOR . $fileName;
                return Json::encode([
                    'files' => [
                        [
                            'name' => $fileName,
                            'size' => $imageFile->size,
                            'url' => $path,
                            'thumbnailUrl' => $path,
                            'deleteUrl' => 'image-delete?name=' . $fileName,
                            'deleteType' => 'POST',
                        ],
                    ],
                ]);
            }
        }

        return '';
    }
}
