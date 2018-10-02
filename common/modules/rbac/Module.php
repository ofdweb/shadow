<?php

namespace common\modules\rbac;

use Yii;
use yii\helpers\Html;
/**
 * rbac module definition class
 */
class Module extends \yii\base\Module
{
    public $package = 'user';
    /*
    public static function navItems()
    {
        return [
            'rbac' => [
                'label' => Yii::t('app', 'Access right'), 
                'icon' => 'user',
                'group' => 'main_menu',
                'items' => [
                    ['label' => Yii::t('app', 'Roles'), 'url' => ['/rbac']],
                ]
            ],
            'user' => [
                'items' => [
                    ['label' => Yii::t('app', 'Access right'), 'url' => ['/user2']],
                ]
            ],
        ];
    }
  
    public static function moduleItems()
    {
        return [
            'user' => [
                'default' => [
                    'label' => Yii::t('app', 'Access and roles'),
                    'items' => [
                        ['label' => Yii::t('app', 'Access right'), 'url' => ['view']]
                    ],
                    'create' => [
                        'items' => [
                            ['label' => Yii::t('app', 'Create 3'), 'url' => ['create']]
                        ],
                    ]
                ],
            ]
        ];
    }
*/
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
