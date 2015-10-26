<?php
return [
    'components' => [
        'request' => [
            'class' => 'common\modules\radiata\components\LangRequestManager',
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '',
        ],
    ],
];
