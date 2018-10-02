<?php

namespace v0lume\yii2\metaTags;

use Yii;
use yii\base\Component;

class MetaTag extends Component
{
    public $generateOg = true;
  
    public function register($model = null)
    {
        /*if($this->generateCsrf && Yii::$app->request->enableCsrfValidation)
        {
            Yii::$app->view->registerMetaTag(['name' => 'csrf-param', 'content' => Yii::$app->request->csrfParam], 'csrf-param');
            Yii::$app->view->registerMetaTag(['name' => 'csrf-token', 'content' => Yii::$app->request->csrfToken], 'csrf-token');
        }*/
      
        if($model && $model->metatag) {
            $metaTag = $model->metatag;
          
            Yii::$app->view->registerMetaTag(['name' => 'title', 'content' => $model->metatag->title], 'title');
            Yii::$app->view->registerMetaTag(['name' => 'keywords', 'content' => $model->metatag->keywords], 'keywords');
            Yii::$app->view->registerMetaTag(['name' => 'description', 'content' => $model->metatag->description], 'description');
          
            if($this->generateOg) {
                Yii::$app->view->registerMetaTag(['property' => 'og:title', 'content' => $model->metatag->title], 'og:title');
                Yii::$app->view->registerMetaTag(['property' => 'og:description', 'content' => $model->metatag->description], 'og:description');
                Yii::$app->view->registerMetaTag(['property' => 'og:url', 'content' => \yii\helpers\Url::to('', true)], 'og:url');
            }
        }
    }
}