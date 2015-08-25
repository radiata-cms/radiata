<?php
namespace tests\codeception\common\Helper;
// here you can define custom actions
// all public methods declared in helper class will be available in $I

use common\modules\radiata\components\Migrator;

class MigratorHelper extends \Codeception\Module
{
    /**
     * @var string
     */
    public $migrationTable = '{{%migrator_migrations}}';

    /**
     * @var Migrator
     */
    public $migrator;

    /**
     * Method called before any suite tests run. Loads User fixture login user
     * to use in acceptance and functional tests.
     * @param array $settings
     */
    public function _beforeSuite($settings = [])
    {
        $this->migrator = new Migrator([
            'migrationPaths' => ['@tests/codeception/common/unit/fixtures/data/components/migrator'],
        ]);
        $this->migrator->setMigrationTable($this->migrationTable);
    }

    public function getMigrationTable()
    {
        return $this->migrationTable;
    }

    public function getMigrator()
    {
        return $this->migrator;
    }

    /**
     * Check migration result
     *
     * @param $migrationName
     * @return bool
     * @throws \yii\base\NotSupportedException
     */
    public function migrationResult($migrationName)
    {
        $result = false;
        switch ($migrationName) {
            case 'm000000_000000_test':
                $tableExists = $this->migrator->getDbConnection()->getTableSchema('test', true);
                if ($tableExists) return true;
                break;
            case 'm000000_000001_test':
                $hasRecords = $this->migrator->getDbConnection()->createCommand('SELECT * FROM ' . $this->migrator->getDbConnection()->getSchema()->quoteTableName('test'))->queryAll();
                if ($hasRecords && count($hasRecords) == 2) return true;
                break;
            case 'm000000_000002_test':
                $tableExists = $this->migrator->getDbConnection()->getTableSchema('subtest', true);
                if ($tableExists) return true;
                break;
        }
        return $result;
    }

    /**
     * Drop table by name (need to manually drop all tables from DB since phpunit clears only data)
     *
     * @param array $tables
     * @throws \yii\base\NotSupportedException
     * @throws \yii\db\Exception
     */
    public function dropTables($tables)
    {
        foreach ($tables as $table) {
            if ($table[0] == '{') {
                $this->migrator->getDbConnection()->createCommand("DROP TABLE IF EXISTS " . $table)->execute();
            } else {
                $this->migrator->getDbConnection()->createCommand("DROP TABLE IF EXISTS " . $this->migrator->getDbConnection()->getSchema()->quoteTableName($table))->execute();
            }
        }
    }
}
