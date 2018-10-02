<?php

namespace modules\metatag\behaviors;

use Yii;
use yii\base\Behavior;
use yii\web\View;

class MetaTagBehavior extends Behavior
{
    public $generateOg = true;
  
    public function events()
    {
        return [
            View::EVENT_BEFORE_RENDER => 'renderMetaTags',
        ];
    }
  
    public function renderMetaTags()
    {
      if(isset(Yii::$app->view->params['metatag']) && (Yii::$app->view->params['metatag'] instanceof \modules\metatag\models\Metatag)) {
            $metaTag = Yii::$app->view->params['metatag'];
          
            Yii::$app->view->registerMetaTag(['name' => 'title', 'content' => $metaTag->title], 'title');
            Yii::$app->view->registerMetaTag(['name' => 'keywords', 'content' => $metaTag->keywords], 'keywords');
            Yii::$app->view->registerMetaTag(['name' => 'description', 'content' => $metaTag->description], 'description');
          
            if($this->generateOg) {
                Yii::$app->view->registerMetaTag(['property' => 'og:title', 'content' => $metaTag->title], 'og:title');
                Yii::$app->view->registerMetaTag(['property' => 'og:description', 'content' => $metaTag->description], 'og:description');
                Yii::$app->view->registerMetaTag(['property' => 'og:url', 'content' => \yii\helpers\Url::to('', true)], 'og:url');
            }
      }
    }
}