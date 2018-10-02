<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'backend',
    'basePath' => dirname(__DIR__),
    'homeUrl' => ['/user'],
    'controllerNamespace' => 'backend\controllers',
    'modules' => [
        'noty' => [
            'class' => 'lo\modules\noty\Module',
        ],
    ],
    'bootstrap' => ['moduleManager'],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            'baseUrl' => '/admin',
            'csrfCookie' => [
                'httpOnly' => true,
                'path' => '/admin',
            ],
        ],
        'user' => [
            'identityCookie' => ['name' => '_identity-backend'],
        ],
        'log' => [
            'targets' => [
                'exchange' => [
                    'class' => 'yii\log\DbTarget',
                    'categories' => ['exchange/*'],
                    'logVars' => [],
                   /* 'prefix' => function ($message) { dd($message);
                        $user = Yii::$app->has('user', true) ? Yii::$app->get('user') : null;
                        $userID = $user ? $user->getId(false) : '-';
                        return "[$userID]";
                    } */
                ],
            ],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
            'cookieParams' => [
                'path' => '/admin',
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',  
                'login' => 'site/login',  
                '<controller:\w+>/<action:\w+>/' => '<controller>/<action>',
            ],
        ],
        'view' => [
          'theme' => [
              'class' => 'common\components\ThemeManager',
              //'theme' => 'adminlte2'
           ],
           /*'as seo' => [
              'class' => 'modules\metatag\behaviors\MetaTagBehavior',
            ]*/
        ],
        'moduleManager' => [
            'class' => 'common\components\ModuleManager',
            'modules' => ['product', 'user', 'rbac', 'file', 'article', 'metatag', 'tag', 'page', 'menu', 'core', 'setting', 'report', 'webform']
        ]
    ],
    'params' => $params,
    'as access' => [
        'class' => 'backend\filters\AccessControl'
    ],
];
