<?php
$params = array_merge(
    require(__DIR__ . '/params.php')
);

return [
    'components' => [
        'errorHandler' => [
            'errorAction' => 'site/errorTest',
        ],
    ],
    'params' => $params,
];
