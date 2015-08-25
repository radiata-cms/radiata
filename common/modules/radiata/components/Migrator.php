<?php
/**
 * Migrator файл класса.
 * Component Migrator - custom migrator for modules
 *
 * @author    a1exsnow <ash@bigmir.net>
 * @license   BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version   0.1.0
 */

namespace common\modules\radiata\components;

use Yii;
use Exception;
use yii\db\Schema;
use common\modules\radiata\helpers\PathHelper;

/**
 * Class Migrator
 */
class Migrator extends \yii\base\Object
{
    /**
     * @var string Custom migration table name
     */
    protected $migrationTable = '{{%radiata_migrations}}';

    /**
     * @var string
     */
    public $modulesDir = 'modules';

    /**
     * @var string
     */
    public $migrationDir = 'migrations';

    /**
     * @var array
     */
    public $migrationPaths = ['@frontend', '@common', '@backend'];

    /**
     * @var string
     */
    public $module = '';

    /**
     * @var string "up" or "down"
     */
    public $direction = 'up';

    /**
     * @var Exception
     */
    public $error;

    /**
     * @var string
     */
    public $connectionID = 'db';

    /**
     * @var Yii\Db\Connection
     */
    protected $_db;

    /**
     * Main migration method. Performs migrate process
     *
     * @return array
     */
    public function migrate()
    {
        $db = $this->getDbConnection();
        $migrations = [];

        if ($db->getTableSchema($this->migrationTable, true) === null) {
            $this->createMigrationTable();
        }

        if ($this->direction == 'up') {
            $migrations = $this->findNewMigrations();
        } elseif ($this->direction == 'down') {
            $migrations = $this->getAppliedMigrations();
        }

        if (count($migrations) > 0) {
            $this->applyMigrations($migrations, $this->direction);
        }

        return $migrations;
    }

    /**
     * Finds new (not applied) migrations
     *
     * @return array
     */
    public function findNewMigrations()
    {
        $appliedMigrations = $this->getAppliedMigrations();

        $migrationPaths = PathHelper::getTargetPaths($this->migrationPaths, $this->module, $this->modulesDir, $this->migrationDir);

        $migrations = [];

        if (count($migrationPaths) > 0) {
            foreach ($migrationPaths as $migrationPath) {
                $migrationRealPath = Yii::getAlias($migrationPath);
                if (is_dir($migrationRealPath)) {
                    $handle = opendir($migrationRealPath);
                    while (($file = readdir($handle)) !== false) {
                        if ($file === '.' || $file === '..') {
                            continue;
                        }
                        $path = $migrationRealPath . DIRECTORY_SEPARATOR . $file;
                        if (preg_match('/^(m(\d{6}_\d{6})_.*?)\.php$/', $file, $matches) && is_file($path)) {
                            $migration = $this->formatMigration($file, $migrationPath);
                            if (!isset($appliedMigrations[$migration['name'] . '/' . $migration['module']])) {
                                $migrations[$migration['name'] . '/' . $migration['module']] = $migration;
                            }
                        }
                    }
                    closedir($handle);
                }
            }
        }

        ksort($migrations);

        return $migrations;
    }

    /**
     * Format migration - fills all data values
     *
     * @param string $file Migration file name
     * @param string $pathAlias Migratoin path yii-alias
     * @return array Formatted migration
     */
    protected function formatMigration($file, $pathAlias)
    {
        $path = Yii::getAlias($pathAlias) . DIRECTORY_SEPARATOR . $file;
        $pathInfo = pathinfo($path);

        $formattedMigration = [
            'path_alias' => $pathAlias
        ];

        $name = str_replace('.' . $pathInfo['extension'], '', $pathInfo['basename']);

        $formattedMigration['name'] = $name;

        $exploded = preg_split('/(\/|\\\)/', $path);
        if (count($exploded) > 0) {
            foreach ($exploded as $explodedPart) {
                if ($explodedPart == $this->migrationDir) break;
                if (empty($formattedMigration['module']) && $explodedPart == $this->modulesDir || !empty($formattedMigration['module'])) {
                    if (empty($formattedMigration['module'])) {
                        $formattedMigration['module'] = $explodedPart;
                    } else {
                        $formattedMigration['module'] .= '/' . $explodedPart;
                    }
                }
            }
            $formattedMigration['module'] = str_replace($this->modulesDir . '/', '', $formattedMigration['module']);
        }

        return $formattedMigration;
    }

    /**
     * Applies migrations
     *
     * @param array $migrations
     */
    protected function applyMigrations($migrations = [])
    {
        foreach ($migrations as $migration) $this->applyMigration($migration, $this->direction);
    }

    /**
     * Applies migration
     *
     * @param array $migration
     * @return void
     * @throws \yii\db\Exception
     */
    protected function applyMigration($migration)
    {
        ob_start();
        if ($this->direction == 'up') {
            $appliedMigrations = $this->getAppliedMigrations();
            if (!isset($appliedMigrations[$migration['name']])) {
                $migrateObj = $this->createMigration($migration);
                if (method_exists($migrateObj, 'safeUp')) {
                    $transaction = $this->_db->beginTransaction();
                    try {
                        if ($migrateObj->safeUp() !== false) {
                            $this->addMigrationHistory($migration);
                            $transaction->commit();
                        } else {
                            $transaction->rollBack();
                        }
                    } catch (Exception $e) {
                        $transaction->rollBack();
                        $this->error = $e;
                    }
                } else {
                    try {
                        if ($migrateObj->up() !== false) {
                            $this->addMigrationHistory($migration);
                        }
                    } catch (Exception $e) {
                        $this->error = $e;
                    }
                }
            }
        } elseif ($this->direction == 'down') {
            $migrateObj = $this->createMigration($migration);
            if (method_exists($migrateObj, 'safeDown')) {
                $transaction = $this->_db->beginTransaction();
                try {
                    if ($migrateObj->safeDown() !== false) {
                        $this->removeMigrationHistory($migration);
                        $transaction->commit();
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    $this->error = $e;
                }
            } else {
                try {
                    if ($migrateObj->down() !== false) {
                        $this->removeMigrationHistory($migration);
                    }
                } catch (Exception $e) {
                    $this->error = $e;
                }
            }
        }
        ob_end_clean();
    }

    /**
     * Get applied migrations from DB
     *
     * @return array
     */
    protected function getAppliedMigrations()
    {
        $appliedMigrations = [];

        $query = (new \yii\db\Query())
            ->from($this->migrationTable)
            ->orderBy(['apply_time' => SORT_ASC]);

        if ($this->module != '') {
            $query->where(['module' => $this->module]);
        }

        $rows = $query->all();
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $appliedMigrations[$row['name'] . '/' . $row['module']] = $row;
            }
        }

        return $appliedMigrations;
    }

    /**
     * Add migration data to migration table
     *
     * @param array $migration
     * @throws \yii\db\Exception
     */
    protected function addMigrationHistory($migration)
    {
        $this->_db->createCommand()->insert($this->migrationTable, [
            'name' => $migration['name'],
            'module' => $migration['module'],
            'path_alias' => $migration['path_alias'],
            'apply_time' => time(),
        ])->execute();
    }

    /**
     * Remove migration data from migration table
     *
     * @param array $migration
     * @throws \yii\db\Exception
     */
    protected function removeMigrationHistory($migration)
    {
        $this->_db->createCommand()->delete($this->migrationTable, [
            'name' => $migration['name'],
            'module' => $migration['module'],
        ])->execute();
    }

    /**
     * Creates a new migration instance.
     *
     * @param array $migration the migration data
     * @return \yii\db\MigrationInterface the migration instance
     */
    protected function createMigration($migration)
    {
        $file = isset($migration['path']) ? Yii::getAlias($migration['path']) . $migration['name'] . '.php' : Yii::getAlias($migration['path_alias'] . DIRECTORY_SEPARATOR . $migration['name'] . '.php');
        require_once($file);
        return new $migration['name']();
    }

    /**
     * Connect to DB
     *
     * @return Yii\Db\Connection connection or make exception
     */
    public function getDbConnection()
    {
        if ($this->_db !== null) {
            return $this->_db;
        } else {
            $connId = $this->connectionID;
            if (($this->_db = Yii::$app->$connId) instanceof Yii\Db\Connection) {
                return $this->_db;
            }
        }
    }

    /**
     * Create migration history table
     *
     * @throws \yii\db\Exception
     */
    protected function createMigrationTable()
    {
        $options = $this->_db->driverName == 'mysql' ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8' : '';

        $this->_db->createCommand()->createTable(
            $this->migrationTable,
            array(
                'id' => Schema::TYPE_PK,
                'name' => Schema::TYPE_STRING . '(255) NOT NULL',
                'module' => Schema::TYPE_STRING . '(255) NOT NULL',
                'path_alias' => Schema::TYPE_STRING . '(255) NOT NULL',
                'apply_time' => Schema::TYPE_INTEGER,
            ),
            $options
        )->execute();

        $this->_db->createCommand()->createIndex(
            "idx_migrations_module",
            $this->migrationTable,
            "module",
            false
        )->execute();
    }

    public function setMigrationTable($tableName)
    {
        $this->migrationTable = $tableName;
    }

    public function getMigrationTable()
    {
        return $this->migrationTable;
    }
}