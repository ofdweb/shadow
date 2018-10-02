<?php

namespace common\modules\menu\frontend\widgets;

use Yii;
use yii\widgets\Menu as BaseMenu;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use modules\menu\models\Menu;

class ListGroupWidget extends BaseMenu
{
    public $tree;
    
    public $depth = 1;
    
    public function init()
    {
        parent::init();
        
        $this->activateParents = true;
        $this->depth = $this->depth > 2 ? 2 : $this->depth;
        $this->tree = $this->tree ?: Menu::MAIN_MENU;
        
        $root = Menu::find()->roots()->where(['tree' => $this->tree])->one();
        $this->items = $this->itemList($root);

        Html::addCssClass($this->options, 'list-group');
    }
    
    private function itemList($root, $depth = 1)
    {
        $key = 0;
        $list = $root->getDescendants(1)->orderBy(['lft' => SORT_ASC])->active()->all();
        
        return ArrayHelper::getColumn($list, function($data) use ($depth, &$key) {
            if ($data->hasEntity) {
                $url = ['/' . lcfirst($data->entity) . '/default/view', 'slug' => $data->slug];
            } elseif ($data->entity === 'Catalog') {
                $url = $data->children ? ['/product/catalog/view', 'slug' => $data->slug] : ['/product/catalog/items', 'slug' => $data->slug];
            } else {
                $url = ['/' . $data->slug . '/default/index'];
            }
          
            $key ++;

            $item = [
              'label' => Yii::t('app', $data->title),
              'url' => $url,
              'options' => ['class' => 'list-group-item'],
            ];
            
            if ($depth != $this->depth) {
                $item['items'] = $this->itemList($data, $depth + 1);
            }
            
            if ($depth == 1) {
                $item['active'] = function ($item, $hasActiveChild, $isItemActive, $widget) use ($key) {
                    return (\App::isFront() && $key == 1) || $isItemActive || $hasActiveChild;
                };
            }
            
            return $item;
        });
    }
}