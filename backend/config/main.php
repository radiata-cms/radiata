<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'radiata-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log', 'radiata'],
    'modules' => [
        'radiata' => [
            'class' => 'common\modules\radiata\Radiata',
            'controllerNamespace' => 'backend\modules\radiata\controllers',
            'layoutPath' => '@backend/views/layouts',
            'viewPath' => '@backend/modules/radiata/views',
            'defaultRoute' => 'radiata',
        ],
    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'loginUrl' => '/radiata/radiata/login',
            'enableAutoLogin' => true,
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
            'errorAction' => 'radiata/radiata/error',
        ],
        'urlManager' => [
            'rules' => [
                '/' => '/radiata/radiata/index',
                '<controller:\w+>/<action:\w+>' => 'radiata/<controller>/<action>'
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
    ],
    'params' => $params,

    'as access' => [
        'class' => 'backend\modules\radiata\components\BackendAccessControl',
        'allowedActions' => [
            'radiata/radiata/login',
            'radiata/radiata/error',
        ],
        'allowedActionsLoggedIn' => [
            'radiata/radiata/logout',
        ]
    ]
];
