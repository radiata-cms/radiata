<?php
namespace frontend\assets;

use yii\web\AssetBundle;

class JSltIE9Asset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
        'js/html5shiv.js',
        'js/respond.min.js',
    ];

    public $jsOptions = [
        'condition' => 'lt IE 9'
    ];
}
