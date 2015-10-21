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
