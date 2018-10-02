<?php

namespace common\modules\menu\frontend\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use modules\menu\models\Menu;

class CategoryWidget extends Widget
{
    public $items;
    
    public function init()
    {
        parent::init();
        
        $this->items = ArrayHelper::getColumn(Menu::itemTree(Menu::CATEGORY_MENU), function($data) {
            $url = ['/product/category/view', 'slug' => $data->slug];

            return [
              'label' => Yii::t('app', $data->title),
              'url' => $url,
              'options' => ['class' => 'list-group-item'],
            ];
        });
    }
}