<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'radiata-fronend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'radiata'],
    'modules' => [
        'radiata' => [
            'class' => 'common\modules\radiata\Radiata',
        ],
        'banner' => [
            'class'               => 'common\modules\banner\Banner',
            'controllerNamespace' => 'frontend\modules\banner\controllers',
            'layoutPath'          => '@frontend/views/layouts',
            'viewPath'            => '@frontend/modules/banner/views',
            'defaultRoute'        => 'banner',
        ],
        'vote'   => [
            'class'               => 'common\modules\vote\Vote',
            'controllerNamespace' => 'frontend\modules\vote\controllers',
            'layoutPath'          => '@frontend/views/layouts',
            'viewPath'            => '@frontend/modules/vote/views',
            'defaultRoute'        => 'vote',
        ],
        'page' => [
            'class'               => 'common\modules\page\Page',
            'controllerNamespace' => 'frontend\modules\page\controllers',
            'layoutPath'          => '@frontend/views/layouts',
            'viewPath'            => '@frontend/modules/page/views',
            'defaultRoute'        => 'page',
        ],
        'news' => [
            'class'               => 'common\modules\news\News',
            'controllerNamespace' => 'frontend\modules\news\controllers',
            'layoutPath'          => '@frontend/views/layouts',
            'viewPath'            => '@frontend/modules/news/views',
            'defaultRoute'        => 'news',
        ],
        'slider' => [
            'class'               => 'common\modules\slider\Slider',
            'controllerNamespace' => 'frontend\modules\slider\controllers',
            'layoutPath'          => '@frontend/views/layouts',
            'viewPath'            => '@frontend/modules/slider/views',
            'defaultRoute'        => 'slider',
        ],
    ],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'user' => [
            'identityClass' => 'common\models\user\User',
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
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
];
