<?php
namespace frontend\modules\radiata\assets;

use yii\web\AssetBundle;

class GalleryAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/layout/gallery/style.css',
        'css/layout/gallery/elastislide.css',
    ];
    public $js = [
        'js/gallery/jquery.tmpl.min.js',
        'js/gallery/jquery.easing.1.3.js',
        'js/gallery/jquery.elastislide.js',
        'js/gallery/gallery.js',
    ];

    public $depends = [
        'frontend\assets\AppAsset',
    ];
}
