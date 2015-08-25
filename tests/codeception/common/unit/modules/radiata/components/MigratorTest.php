<?php

namespace tests\codeception\common\unit\modules\radiata\components;

use Yii;
use tests\codeception\common\unit\DbTestCase;
use Codeception\Specify;

/**
 * Migrator test
 */
class MigratorTest extends DbTestCase
{
    use Specify;

    /**
     * IMPORTANT! Specify all dynamic tables from test here
     *
     * @var array
     */
    public $dropTables = ['test', 'subtest'];

    public function setUp()
    {
        parent::setUp();

        $this->dropTables[] = $this->tester->getMigrationTable();
        $this->tester->dropTables($this->dropTables);
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->dropTables[] = $this->tester->getMigrationTable();
        $this->tester->dropTables($this->dropTables);
    }

    /**
     * Migration table creation test
     */
    public function testMigrationTableCreated()
    {
        $this->tester->getMigrator()->direction = 'wrong';
        $this->tester->getMigrator()->migrate();
        $tableExists = $this->tester->getMigrator()->getDbConnection()->getTableSchema($this->tester->getMigrationTable(), true);

        $this->specify('create custom migration table, if it is not present in DB', function () use ($tableExists) {
            expect('see migration table in DB', $tableExists)->notNull();
        });
    }

    /**
     * All up migrations test
     *
     * @depends testMigrationTableCreated
     */
    public function testMigrationAllUp()
    {
        $this->tester->getMigrator()->direction = 'up';
        $this->tester->getMigrator()->migrate();

        $migrationResults = [
            'm000000_000000_test' => $this->tester->migrationResult('m000000_000000_test'),
            'm000000_000001_test' => $this->tester->migrationResult('m000000_000001_test'),
            'm000000_000002_test' => $this->tester->migrationResult('m000000_000002_test'),
        ];

        $this->specify('migrate up all new migratoins', function () use ($migrationResults) {
            expect('see migration m000000_000000_test up success', $migrationResults['m000000_000000_test'])->true();
            expect('see migration m000000_000001_test up success', $migrationResults['m000000_000001_test'])->true();
            expect('see migration m000000_000002_test up success', $migrationResults['m000000_000002_test'])->true();
        });
    }

    /**
     * All down migrations test
     *
     * @depends testMigrationTableCreated
     */
    public function testMigrationDown()
    {
        $this->tester->getMigrator()->direction = 'down';
        $this->tester->getMigrator()->migrate();

        $migrationResults = [
            'm000000_000000_test' => $this->tester->migrationResult('m000000_000000_test'),
            'm000000_000002_test' => $this->tester->migrationResult('m000000_000002_test'),
        ];

        $this->specify('migrate down all migratoins', function () use ($migrationResults) {
            expect('see migration m000000_000000_test down success', $migrationResults['m000000_000000_test'])->false();
            expect('see migration m000000_000002_test down success', $migrationResults['m000000_000002_test'])->false();
        });
    }

    /**
     * All up migrations test for module
     *
     * @depends testMigrationTableCreated
     */
    public function testMigrationUpModule()
    {
        $this->tester->getMigrator()->direction = 'up';
        $this->tester->getMigrator()->module = 'module/submodule';
        $this->tester->getMigrator()->migrate();

        $migrationResults = [
            'm000000_000002_test' => $this->tester->migrationResult('m000000_000002_test'),
        ];

        $this->specify('migrate up all module migratoins', function () use ($migrationResults) {
            expect('see migration m000000_000002_test down success', $migrationResults['m000000_000002_test'])->true();
        });
    }

    /**
     * All down migrations test for module
     *
     * @depends testMigrationTableCreated
     */
    public function testMigrationDownModule()
    {
        $this->tester->getMigrator()->direction = 'down';
        $this->tester->getMigrator()->module = 'module/submodule';
        $this->tester->getMigrator()->migrate();

        $migrationResults = [
            'm000000_000002_test' => $this->tester->migrationResult('m000000_000002_test'),
        ];

        $this->specify('migrate up all module migratoins', function () use ($migrationResults) {
            expect('see migration m000000_000002_test down success', $migrationResults['m000000_000002_test'])->false();
        });
    }


}
