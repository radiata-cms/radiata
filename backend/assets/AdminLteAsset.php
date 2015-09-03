<?php
namespace backend\assets;

use yii\base\Exception;
use yii\web\AssetBundle;

class AdminLteAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte';
    public $css = [
        'dist/css/AdminLTE.min.css',
        '//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css',
    ];
    public $js = [
        'dist/js/app.min.js',
        'plugins/fastclick/fastclick.min.js',
        'dist/js/app.min.js',
        'plugins/sparkline/jquery.sparkline.min.js',
        'plugins/jvectormap/jquery-jvectormap-1.2.2.min.js',
        'plugins/jvectormap/jquery-jvectormap-world-mill-en.js',
        'plugins/slimScroll/jquery.slimscroll.min.js',
        'plugins/chartjs/Chart.min.js',
        //'dist/js/pages/dashboard2.js',
        'plugins/iCheck/icheck.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];

    /**
     * @var string|bool Choose skin color, eg. `'skin-blue'` or set `false` to disable skin loading
     * @see https://almsaeedstudio.com/themes/AdminLTE/documentation/index.html#layout
     */
    const ADMIN_LTE_SKIN = 'blue';

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (self::ADMIN_LTE_SKIN) {
            $this->css[] = sprintf('dist/css/skins/skin-%s.min.css', self::ADMIN_LTE_SKIN);
            $this->css[] = sprintf('plugins/iCheck/square/%s.css', self::ADMIN_LTE_SKIN);
        }
        parent::init();
    }
}