<?php

namespace common\modules\file\backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\helpers\Json;

/**
 * Default controller for the `file` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
  
    public function actionImageUpload()
    {
        
        $directory = Yii::getAlias('@files/temp') . DIRECTORY_SEPARATOR;
      
        if (!is_dir($directory)) {
            FileHelper::createDirectory($directory);
        }
      
        $imageFile = UploadedFile::getInstanceByName('UserProfile[image_id]');
      
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
