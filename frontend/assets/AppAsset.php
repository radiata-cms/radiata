<?php
namespace frontend\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/flags.css',
        'css/layout/font-awesome.min.css',
        'css/layout/animate.min.css',
        'css/layout/prettyPhoto.css',
        'css/layout/main.css',
        'css/layout/responsive.css',
    ];
    public $js = [
        'js/bootstrap.min.js',
        'js/jquery.prettyPhoto.js',
        'js/jquery.isotope.min.js',
        'js/main.js',
        'js/wow.min.js',
    ];

    public $jsOptions = [
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
