<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'Admin panel',
    'language' => 'uz',
    'basePath' => dirname(__DIR__),
    'name' => 'Chust Pichoqlari',
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'lists' => [
            'class' => 'backend\modules\lists\Module',
        ],
        'products' => [
            'class' => 'backend\modules\products\Module',
        ],
        'prices' => [
            'class' => 'backend\modules\prices\Module',
        ],
        'orders' => [
            'class' => 'backend\modules\orders\Orders',
        ],
        'transactions' => [
            'class' => 'backend\modules\transactions\Transactions',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\user\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
//                    '@backend/views' => '@backend/views',
//                    '@backend/views' => '@vendor/dmstr/yii2-adminlte-asset/example-views/yiisoft/yii2-app',
//                    '@dektrium/user/views/security' => '@backend/views/security',
//                    '@dektrium/user/views/admin' => '@backend/views/user/admin'
                ],
                'basePath' => dirname(__DIR__),
            ],
        ],
        'assetManager' => [
            'bundles' => [
                'dmstr\web\AdminLteAsset' => [
                    'skin' => 'skin-blue',
                ],
            ],
        ],
        'i18n' => [
            'translations' => [
                'main*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'sourceLanguage' => 'uz',
                    'fileMap' => [
                        'main' => 'main.php',
                    ],
                ],
                'yii*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'sourceLanguage' => 'uz',
                    'fileMap' => [
                        'yii' => 'yii.php',
                    ],
                ]
            ],
        ],
    ],
    'params' => $params,
];
