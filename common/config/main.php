<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'sourceLanguage' => 'en-US',
    'language' => 'en-US',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache'
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'class' => 'common\modules\radiata\components\LangUrlManager',
        ],
        'request' => [
            'class'               => 'common\modules\radiata\components\LangRequestManager',
            'cookieValidationKey' => 'OgBZUGfC9ZJbeT4hDfjSHhBx-IEsKKK4',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
    ],
];