<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require(__DIR__ . '/../../vendor/autoload.php');
require(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../../common/config/bootstrap.php');
require(__DIR__ . '/../config/bootstrap.php');

$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../common/config/main.php'),
    require(__DIR__ . '/../../common/config/main-local.php'),
    require(__DIR__ . '/../config/main.php'),
    require(__DIR__ . '/../config/main-local.php')
);

/*
 * Custom Radiata configurator
 */
$configurator = new common\modules\radiata\components\Configurator([
    'configPaths' => ['@common', '@backend']
]);
$configurator->loadAll();
$finalConfig = $configurator->mergeConfig($config);

$application = new yii\web\Application($finalConfig);
$application->run();