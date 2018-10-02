<?php

Yii::$classMap['yii\helpers\Html'] = '@common/components/Html.php';
Yii::$classMap['yii\imagine\Image'] = '@common/components/Image.php';

return [
    'sourceLanguage' => 'ru',
    'language' => 'ru',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@modules' => '@common/modules',
    ],
    'bootstrap' => ['log'],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'name' => 'CMS v0.1',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            //'defaultRoles' => ['guest']
        ],
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'modules\user\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['httpOnly' => true],
            'on afterLogin' => ['modules\user\models\UserProfile', 'updateLastVizit']
        ],
       /* 'queue' => [
            'class' => 'yii\queue\db\Queue',
            'db' => 'db',
            'tableName' => '{{%queue}}',
            'channel' => 'default',
            'mutex' => \yii\mutex\MysqlMutex::class,
        ], */
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'enabled' => !YII_DEBUG,
                    'class' => 'yii\log\DbTarget',
                    'levels' => ['error', 'warning'],
                    'logVars' => []
                ],
            ],
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'dateFormat' => 'php:Y-m-d',
            'datetimeFormat' => 'php:Y-m-d H:i',
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
            'currencyCode' => 'RUB',
            'nullDisplay' => Yii::t('app', 'Пусто'),
        ],
        'filedb' => [
            'class' => 'yii2tech\filedb\Connection',
            'path' => '@common/data/static',
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\DbMessageSource',
                    'sourceLanguage' => 'ru',
                    'on missingTranslation' => ['common\components\YandexTranslation', 'handleMissingTranslation']
                ],
                'yii2mod.settings' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yii2mod/settings/messages',
                ],
                'noty' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@lo/modules/noty/messages',
                ],
            ],
        ],
        'settings' => [
            'class' => 'yii2mod\settings\components\Settings',
            'modelClass' => 'backend\models\SettingModel'
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@backend/runtime/cache'
        ],
    ],
];
