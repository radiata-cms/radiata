<?php
namespace tests\codeception\common\Helper;
// here you can define custom actions
// all public methods declared in helper class will be available in $I

use common\modules\radiata\components\Configurator;

class ConfiguratorHelper extends \Codeception\Module
{
    /**
     * @var Configurator
     */
    public $configurator;

    public function getConfigurator()
    {
        return $this->configurator;
    }

    /**
     * @param array $configPaths
     * @return Configurator
     */
    public function setConfigurator($configPaths = [])
    {
        $this->configurator = new Configurator([
            'configPaths' => $configPaths,
        ]);

        return $this->configurator;
    }

    /**
     * @param array $config
     * @return \yii\web\Application
     */
    public function runApplication($config = [])
    {
        $application = new \yii\web\Application($config);

        return $application;
    }
}
