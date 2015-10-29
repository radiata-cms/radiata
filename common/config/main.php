<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'sourceLanguage' => 'en-US',
    'language'   => 'en-US',
    'components' => [
        'cache'      => [
            'class'     => 'yii\caching\FileCache',
            'cachePath' => '@common/runtime/cache'
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
        'assetManager' => [
            'class'     => 'yii\web\AssetManager',
            'forceCopy' => YII_DEBUG ? true : false,
        ],
        'formatter' => [
            'class'          => 'yii\i18n\Formatter',
            'dateFormat'     => 'm/j/Y',
            'datetimeFormat' => 'php: M j, Y H:i:s',
            'timeFormat'     => 'H:i:s',
        ]
    ],
];