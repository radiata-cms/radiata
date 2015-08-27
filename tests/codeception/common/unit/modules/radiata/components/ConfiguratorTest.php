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
            expect('see proper ID value', $config['id'])->equals('radiata-tests');
            expect('see proper params adminEmailFake value', $config['params']['adminEmailFake'])->equals('test@test.com');
            expect('see proper params adminNameFake value', $config['params']['adminNameFake'])->equals('Admin');
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
            expect('see proper components cache keyPrefix value', $application->id)->equals('radiata-tests');
            expect('see proper params adminEmailFake value', $application->params['adminEmailFake'])->equals('test@test.com');
            expect('see proper params adminNameFake value', $application->params['adminNameFake'])->equals('Admin');
        });
    }

    /**
     * I18n config messages test
     */
    public function testI18nConfiguration()
    {
        $config = $this->tester->getConfigurator()->config;

        $this->specify('include all configs', function () use ($config) {
            expect('see proper category mask for module', $config['components']['i18n']['translations']['c/module*'])->notNull();
            expect('see proper category mask for submodule', $config['components']['i18n']['translations']['c/module/submodule*'])->notNull();
            expect('see proper messages file map for module', $config['components']['i18n']['translations']['c/module*']['fileMap']['c/module/test'])->notNull();
            expect('see proper messages file map for submodule', $config['components']['i18n']['translations']['c/module/submodule*']['fileMap']['c/module/submodule/test'])->notNull();
        });
    }
}
