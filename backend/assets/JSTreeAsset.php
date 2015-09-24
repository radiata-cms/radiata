<?php
namespace backend\assets;

use yii\web\AssetBundle;

class JSTreeAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'jstree/themes/proton/style.min.css',
    ];
    public $js = [
        'jstree/jstree.min.js',
        'jstree/jstree.contextmenu.js',
        'jstree/jstree.dnd.js',
        'jstree/jstree.massload.js',
        'jstree/jstree.state.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
