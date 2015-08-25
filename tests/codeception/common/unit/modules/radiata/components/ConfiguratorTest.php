<?php

namespace tests\codeception\common\unit\modules\radiata\components;

use Yii;
use tests\codeception\common\unit\DbTestCase;
use Codeception\Specify;

/**
 * Configurator test
 */
class ConfiguratorTest extends DbTestCase
{

    use Specify;

    public function setUp()
    {
        parent::setUp();

        $this->tester->setConfigurator(['@tests/codeception/common/unit/fixtures/data/components/configurator'])->loadAll();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * All loaded configs test
     */
    public function testModulesMergedConfiguration()
    {
        $config = $this->tester->getConfigurator()->config;

        $this->specify('include all configs', function () use ($config) {
            expect('see proper components cache keyPrefix value', $config['components']['cache']['keyPrefix'])->equals('radiata');
            expect('see proper components errorHandler errorAction value', $config['components']['errorHandler']['errorAction'])->equals('site/errorTestLocal');
            expect('see proper params adminEmail value', $config['params']['adminEmail'])->equals('test@test.com');
            expect('see proper params adminName value', $config['params']['adminName'])->equals('Admin');
        });
    }

    /**
     * Application run test
     *
     * @depends testModulesMergedConfiguration
     */
    public function testApplicationRun()
    {
        $config = $this->tester->getConfigurator()->config;
        $application = $this->tester->runApplication($config);

        $this->specify('include all configs', function () use ($application) {
            expect('see proper components cache keyPrefix value', $application->components['cache']['keyPrefix'])->equals('radiata');
            expect('see proper components errorHandler errorAction value', $application->components['errorHandler']['errorAction'])->equals('site/errorTestLocal');
            expect('see proper params adminEmail value', $application->params['adminEmail'])->equals('test@test.com');
            expect('see proper params adminName value', $application->params['adminName'])->equals('Admin');
        });
    }
}
