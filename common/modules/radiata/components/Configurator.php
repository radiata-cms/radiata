<?php
/**
 * Configurator файл класса.
 * Component Configurator - custom configurator for modules
 *
 * @author    a1exsnow <ash@bigmir.net>
 * @license   BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version   0.1.0
 */

namespace common\modules\radiata\components;

use Yii;
use common\modules\radiata\helpers\PathHelper;
use yii\helpers\ArrayHelper;

/**
 * Class Configurator
 */
class Configurator extends \yii\base\Object
{
    /**
     * @var array
     */
    public $configPaths = ['@frontend', '@common', '@backend'];

    /**
     * @var string
     */
    public $configDir = 'config';

    /**
     * @var string
     */
    public $modulesDir = 'modules';

    /**
     * @var array
     */
    public $configFilesNames = [
        'bootstrap', 'main'
    ];

    /**
     * @var string
     */
    public $additionalSuffix = '-local';

    /**
     * @var string
     */
    public $module = '';

    /**
     * @var array
     */
    public $config = [];


    /**
     * Gather all modules configurations
     *
     * @return array
     */
    public function loadAll()
    {
        $configPaths = PathHelper::getTargetPaths($this->configPaths, $this->module, $this->modulesDir, $this->configDir, false);

        $finalConfig = [];
        foreach ($configPaths as $configPath) {
            $realPath = Yii::getAlias($configPath);
            foreach ($this->configFilesNames as $configFilesName) {
                if (file_exists($realPath . DIRECTORY_SEPARATOR . $configFilesName . '.php'))
                    $finalConfig = ArrayHelper::merge($finalConfig, require($realPath . DIRECTORY_SEPARATOR . $configFilesName . '.php'));
                if ($this->additionalSuffix && file_exists($realPath . DIRECTORY_SEPARATOR . $configFilesName . $this->additionalSuffix . '.php'))
                    $finalConfig = ArrayHelper::merge($finalConfig, require($realPath . DIRECTORY_SEPARATOR . $configFilesName . $this->additionalSuffix . '.php'));
            }

        }

        $this->config = $finalConfig;

        return $finalConfig;
    }

    /**
     * Merge configurations
     *
     * @return array
     */
    public function mergeConfig($customConfig)
    {
        return ArrayHelper::merge($customConfig, $this->config);
    }
}