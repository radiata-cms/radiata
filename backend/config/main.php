<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id'         => 'radiata-backend',
    'basePath'   => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap'  => ['log', 'radiata'],
    'modules'    => [
        'radiata' => [
            'class'        => 'common\modules\radiata\Radiata',
            'controllerNamespace' => 'backend\modules\radiata\controllers',
            'layoutPath'   => '@backend/views/layouts',
            'viewPath'     => '@backend/modules/radiata/views',
            'defaultRoute' => 'radiata',
        ],
        'news'    => [
            'class'               => 'common\modules\news\News',
            'controllerNamespace' => 'backend\modules\news\controllers',
            'layoutPath'          => '@backend/views/layouts',
            'viewPath'            => '@backend/modules/news/views',
            'defaultRoute'        => 'news',
        ],
        'banner'  => [
            'class'               => 'common\modules\banner\Banner',
            'controllerNamespace' => 'backend\modules\banner\controllers',
            'layoutPath'          => '@backend/views/layouts',
            'viewPath'            => '@backend/modules/banner/views',
            'defaultRoute'        => 'banner',
        ],
        'vote'    => [
            'class'               => 'common\modules\vote\Vote',
            'controllerNamespace' => 'backend\modules\vote\controllers',
            'layoutPath'          => '@backend/views/layouts',
            'viewPath'            => '@backend/modules/vote/views',
            'defaultRoute'        => 'vote',
        ],
        'menu' => [
            'class'               => 'common\modules\menu\Menu',
            'controllerNamespace' => 'backend\modules\menu\controllers',
            'layoutPath'          => '@backend/views/layouts',
            'viewPath'            => '@backend/modules/menu/views',
            'defaultRoute'        => 'menu',
        ],
        'page' => [
            'class'               => 'common\modules\page\Page',
            'controllerNamespace' => 'backend\modules\page\controllers',
            'layoutPath'          => '@backend/views/layouts',
            'viewPath'            => '@backend/modules/page/views',
            'defaultRoute'        => 'page',
        ],
        'slider' => [
            'class'               => 'common\modules\slider\Slider',
            'controllerNamespace' => 'backend\modules\slider\controllers',
            'layoutPath'          => '@backend/views/layouts',
            'viewPath'            => '@backend/modules/slider/views',
            'defaultRoute'        => 'slider',
        ],
    ],
    'components' => [
        'user'               => [
            'identityClass' => 'common\models\user\User',
            'loginUrl'      => '/radiata/radiata/login',
            'enableAutoLogin' => true,
        ],
        'log'                => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler'       => [
            'errorAction' => 'radiata/radiata/error',
        ],
        'urlManager'         => [
            'rules' => [
                '/'                                             => '/radiata/radiata/index',
                '<controller:\w+>/<action:[\w-]+>/<id:\d+>'     => 'radiata/<controller>/<action>',
                '<controller:\w+>/<action:[\w-]+>'              => 'radiata/<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:[\w-]+>/<id:\d+>' => '<module>/<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:[\w-]+>' => '<module>/<controller>/<action>',
            ],
        ],
        'urlManagerFrontEnd' => [
            'class'           => 'common\modules\radiata\components\LangUrlManager',
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'enableStrictParsing' => false,
            'baseUrl'         => 'http://' . str_replace('admin.', '', $_SERVER['HTTP_HOST']) . '/',
        ],
    ],
    'params'     => $params,

    'as access'  => [
        'class'          => 'backend\modules\radiata\components\BackendAccessControl',
        'allowedActions' => [
            'radiata/radiata/login',
            'radiata/radiata/error',
            'radiata/radiata/lock-screen',
        ],
        'allowedActionsLoggedIn' => [
            'radiata/radiata/logout',
        ]
    ],
];
