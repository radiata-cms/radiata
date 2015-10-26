<?php

// NOTE: Make sure this file is not accessible when deployed to production
if (!in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1'])) {
    die('You are not allowed to access this file.');
}

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'test');

require(__DIR__ . '/../../vendor/autoload.php');
require(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../../common/config/bootstrap.php');
require(__DIR__ . '/../config/bootstrap.php');

$config = require(__DIR__ . '/../../tests/codeception/config/frontend/acceptance.php');

/*
 * Custom Radiata configurator
 */
$configurator = new common\modules\radiata\components\Configurator([
    'configPaths' => ['@common', '@frontend']
]);
$configurator->loadAll();
$finalConfig = $configurator->mergeConfig($config);

(new yii\web\Application($finalConfig))->run();
