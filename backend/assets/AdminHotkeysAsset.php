<?php
namespace backend\assets;

use yii\web\AssetBundle;

class AdminHotkeysAsset extends AssetBundle
{
    public $sourcePath = '@bower/jquery.hotkeys';
    public $js = [
        'jquery.hotkeys.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
