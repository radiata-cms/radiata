<?php
$params = array_merge(
    require(__DIR__ . '/params.php')
);

return [
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'keyPrefix' => 'radiata',
        ],
    ],
    'params' => $params,
];
