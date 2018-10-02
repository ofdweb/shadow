<?php

namespace common\modules\article;

use Yii;

/**
 * article module definition class
 */
class Module extends \yii\base\Module
{
    /*
    public static function navItems()
    {
        return [
            'article' => [
                'label' => Yii::t('app', 'Статьи'), 
                'icon' => 'bookmark-o',
                'group' => 'content_menu',
                'items' => [
                    ['label' => Yii::t('app', 'Список'), 'url' => ['/article/default/index']],
                    ['label' => Yii::t('app', 'Добавить статью'), 'url' => ['/article/default/create']]
                ]
            ]
        ];
    }
  
    public static function moduleItems()
    {
        return [
            'article' => [
                'default' => [
                    'label' => Yii::t('app', 'Контекстное меню'),
                    'items' => [
                        ['label' => Yii::t('app', 'Список'), 'url' => ['index']],
                        ['label' => Yii::t('app', 'Создать'), 'url' => ['create']],
                    ],
                    'update' => [
                        'items' => [
                            ['label' => Yii::t('app', 'Изменить'), 'url' => ['update', 'id'  => Yii::$app->request->get('id')]],
                            ['label' => Yii::t('app', 'Просмотр'), 'url' => ['view', 'id'  => Yii::$app->request->get('id')]],
                            ['label' => Yii::t('app', 'Удалить'), 'url' => ['delete', 'id' => Yii::$app->request->get('id')]]
                        ]
                    ],
                    'view' => [
                        'items' => [
                            ['label' => Yii::t('app', 'Изменить'), 'url' => ['update', 'id'  => Yii::$app->request->get('id')]],
                            ['label' => Yii::t('app', 'Просмотр'), 'url' => ['view', 'id'  => Yii::$app->request->get('id')]],
                            ['label' => Yii::t('app', 'Удалить'), 'url' => ['delete', 'id' => Yii::$app->request->get('id')]]
                        ]
                    ]
                ]
            ]
        ];
    }
    */
    public function getMainMenu()
    {
        return [
            'content' => [
                'label' => Yii::t('app', 'Статьи'), 
                'icon' => 'bookmark-o',
                'items' => [
                    ['label' => Yii::t('app', 'Список'), 'url' => ['/article/default/index']],
                    ['label' => Yii::t('app', 'Добавить статью'), 'url' => ['/article/default/create']]
                ]
            ]
        ];
    }
  
    public function getContextualLinks()
    {
        $id = Yii::$app->request->get('id');
        $visible = Yii::$app->request->get('id', false);

        return [
          ['label' => Yii::t('app', 'Список'), 'url' => ['index']],
          ['label' => Yii::t('app', 'Создать'), 'url' => ['create']],
          ['label' => Yii::t('app', 'Изменить'), 'url' => ['update', 'id' => $id], 'visible' => $visible],
          ['label' => Yii::t('app', 'Просмотр'), 'url' => ['view', 'id' => $id], 'visible' => $visible],
          ['label' => Yii::t('app', 'Удалить'), 'url' => ['delete', 'id'=> $id], 'visible' => $visible]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
