<?php
return [
    'bootstrap'  => ['assetsAutoCompress'],
    'components' => [
        'request' => [
            'class' => 'common\modules\radiata\components\LangRequestManager',
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '',
        ],
        'assetsAutoCompress' => [
            'class'          => '\skeeks\yii2\assetsAuto\AssetsAutoCompressComponent',
            'enabled'        => true,
            'jsCompress'     => true,
            'cssFileCompile' => true,
            'jsFileCompile'  => true,
        ],
    ],
];
