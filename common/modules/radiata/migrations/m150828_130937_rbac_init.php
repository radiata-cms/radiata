<?php

use common\models\user\User;
use yii\db\Migration;
use yii\helpers\ArrayHelper;

class m150828_130937_rbac_init extends Migration
{
    protected $originalMigrationPath = '@yii/rbac/migrations';

    protected $originalMigrationName = 'm140506_102106_rbac_init';

    protected $originalMigration;

    public function init()
    {
        require_once(Yii::getAlias($this->originalMigrationPath) . DIRECTORY_SEPARATOR . $this->originalMigrationName . '.php');

        $this->originalMigration = new $this->originalMigrationName();

        parent::init();
    }

    public function safeUp()
    {
        $this->originalMigration->up();

        $authManager = Yii::$app->authManager;

        $this->alterColumn($authManager->assignmentTable, 'user_id', $this->integer()->notNull());

        //fk
        $this->addForeignKey(
            "fk_assignment_user_id",
            $authManager->assignmentTable,
            'user_id',
            '{{%radiata_user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $developerRole = $authManager->createRole('developer');
        $adminRole = $authManager->createRole('admin');
        $managerRole = $authManager->createRole('manager');
        $userRole = $authManager->createRole('user');

        $authManager->add($developerRole);
        $authManager->add($adminRole);
        $authManager->add($managerRole);
        $authManager->add($userRole);

        $authManager->addChild($managerRole, $userRole);
        $authManager->addChild($adminRole, $managerRole);
        $authManager->addChild($developerRole, $adminRole);

        $permissionRadiataModule = $authManager->createPermission('Radiata Module');
        $authManager->add($permissionRadiataModule);

        $permissionRadiataModuleDashboard = $authManager->createPermission('Radiata Module. Dashboard');
        $authManager->add($permissionRadiataModuleDashboard);
        $authManager->addChild($permissionRadiataModule, $permissionRadiataModuleDashboard);

        $permissionRadiataModuleAdminLog = $authManager->createPermission('Radiata Module. Admin Log');
        $authManager->add($permissionRadiataModuleAdminLog);
        $authManager->addChild($permissionRadiataModule, $permissionRadiataModuleAdminLog);

        $permissionRadiataModuleLangs = $authManager->createPermission('Radiata Module. Languages');
        $authManager->add($permissionRadiataModuleLangs);
        $authManager->addChild($permissionRadiataModule, $permissionRadiataModuleLangs);

        $permissionRadiataModuleUsers = $authManager->createPermission('Radiata Module. Users');
        $authManager->add($permissionRadiataModuleUsers);
        $authManager->addChild($permissionRadiataModule, $permissionRadiataModuleUsers);

        $user = new User();
        $user->username = 'developer';
        $user->first_name = 'Developer';
        $user->last_name = 'Developer';
        $user->email = 'developer@site.dev';
        $user->setPassword('developer^^');
        $user->generateAuthKey();
        $user->status = User::STATUS_ACTIVE;
        $user->created_at = time();
        $user->updated_at = time();
        Yii::$app->db->createCommand()
            ->insert(User::tableName(),
                $user->attributes,
                ArrayHelper::getColumn($user, 'attributes'))
            ->execute();
        $authManager->assign($developerRole, Yii::$app->db->getLastInsertID());

        $user = new User();
        $user->username = 'admin';
        $user->first_name = 'Admin';
        $user->last_name = 'Admin';
        $user->email = 'admin@site.dev';
        $user->setPassword('admin^^');
        $user->generateAuthKey();
        $user->status = User::STATUS_ACTIVE;
        $user->created_at = time();
        $user->updated_at = time();
        Yii::$app->db->createCommand()
            ->insert(User::tableName(),
                $user->attributes,
                ArrayHelper::getColumn($user, 'attributes'))
            ->execute();
        $authManager->assign($adminRole, Yii::$app->db->getLastInsertID());

        $user = new User();
        $user->username = 'manager';
        $user->first_name = 'Manager';
        $user->last_name = 'Manager';
        $user->email = 'manager@site.dev';
        $user->setPassword('manager^^');
        $user->generateAuthKey();
        $user->status = User::STATUS_ACTIVE;
        $user->created_at = time();
        $user->updated_at = time();
        Yii::$app->db->createCommand()
            ->insert(User::tableName(),
                $user->attributes,
                ArrayHelper::getColumn($user, 'attributes'))
            ->execute();
        $authManager->assign($managerRole, Yii::$app->db->getLastInsertID());

        $user = new User();
        $user->username = 'user';
        $user->first_name = 'User';
        $user->last_name = 'User';
        $user->email = 'user@site.dev';
        $user->setPassword('user^^');
        $user->generateAuthKey();
        $user->status = User::STATUS_ACTIVE;
        $user->created_at = time();
        $user->updated_at = time();
        Yii::$app->db->createCommand()
            ->insert(User::tableName(),
                $user->attributes,
                ArrayHelper::getColumn($user, 'attributes'))
            ->execute();
        $authManager->assign($userRole, Yii::$app->db->getLastInsertID());
    }

    public function safeDown()
    {
        $this->originalMigration->down();

        $this->delete('{{%radiata_user}}', ['in', 'username', ['developer', 'admin', 'manager', 'user']]);
    }
}
