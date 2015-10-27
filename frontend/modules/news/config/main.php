<?
return [
    'components' => [
        'urlManager' => [
            'rules' => [
                '/news/tag/<name>/p<page:\d+>'      => 'news/tag/view',
                '/news/tag/<name>'                  => 'news/tag/view',
                '/news/category/<slug>/p<page:\d+>' => 'news/category/view',
                '/news/category/<slug>'             => 'news/category/view',
                '/news/<slug>'                      => 'news/news/view',
            ],
        ],
    ],
];
?>