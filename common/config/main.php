<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'sourceLanguage' => 'en-US',
    'language'   => 'en-US',
    'components' => [
        'cache'      => [
            'class' => 'yii\caching\FileCache'
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'enableStrictParsing' => false,
            'class'           => 'common\modules\radiata\components\LangUrlManager',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
    ],
];