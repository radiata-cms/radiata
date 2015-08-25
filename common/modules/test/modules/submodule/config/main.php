<?php
$params = array_merge(require(__DIR__ . '/params.php'));

return [
    'components' => [
        'cache' => [
            'keyPrefix' => 'radiata',
        ],
    ],
    'params' => $params,
];
