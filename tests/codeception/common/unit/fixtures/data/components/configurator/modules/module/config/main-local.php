<?php
return [
    'id' => 'radiata-tests',
    'basePath' => dirname(__DIR__),
    'components' => [
        'errorHandler' => [
            'errorAction' => 'site/errorTestLocal',
        ],
    ],
];
