<?php
namespace frontend\modules\slider\assets;

use yii\web\AssetBundle;

class SliderAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/layout/slider.css',
    ];
    public $js = [
    ];

    public $depends = [
        'frontend\assets\AppAsset',
    ];
}
