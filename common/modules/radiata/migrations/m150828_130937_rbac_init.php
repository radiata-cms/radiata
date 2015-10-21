<?php

use common\models\user\User;
use yii\db\Migration;

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
            '{{%user}}',
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

        $permissionRadiataModuleTextBlocks = $authManager->createPermission('Radiata Module. Text blocks');
        $authManager->add($permissionRadiataModuleTextBlocks);
        $authManager->addChild($permissionRadiataModule, $permissionRadiataModuleTextBlocks);


        $permissionNewsModule = $authManager->createPermission('News Module');
        $authManager->add($permissionNewsModule);

        $permissionNewsModuleCategories = $authManager->createPermission('News Module. Categories');
        $authManager->add($permissionNewsModuleCategories);
        $authManager->addChild($permissionNewsModule, $permissionNewsModuleCategories);

        $permissionNewsModuleTape = $authManager->createPermission('News Module. News tape');
        $authManager->add($permissionNewsModuleTape);
        $authManager->addChild($permissionNewsModule, $permissionNewsModuleTape);

        $permissionNewsModuleTags = $authManager->createPermission('News Module. Tags');
        $authManager->add($permissionNewsModuleTags);
        $authManager->addChild($permissionNewsModule, $permissionNewsModuleTags);

        $permissionBannerModule = $authManager->createPermission('Banners Module');
        $authManager->add($permissionBannerModule);

        $permissionVoteModule = $authManager->createPermission('Votes Module');
        $authManager->add($permissionVoteModule);

        $user = new User();
        $user->username = 'developer';
        $user->first_name = 'Developer';
        $user->last_name = 'Developer';
        $user->email = 'developer@site.dev';
        $user->setPassword('developer^^');
        $user->generateAuthKey();
        $user->save();
        $authManager->assign($developerRole, $user->id);

        $user = new User();
        $user->username = 'admin';
        $user->first_name = 'Admin';
        $user->last_name = 'Admin';
        $user->email = 'admin@site.dev';
        $user->setPassword('admin^^');
        $user->generateAuthKey();
        $user->save();
        $authManager->assign($adminRole, $user->id);

        $user = new User();
        $user->username = 'manager';
        $user->first_name = 'Manager';
        $user->last_name = 'Manager';
        $user->email = 'manager@site.dev';
        $user->setPassword('manager^^');
        $user->generateAuthKey();
        $user->save();
        $authManager->assign($managerRole, $user->id);

        $user = new User();
        $user->username = 'user';
        $user->first_name = 'User';
        $user->last_name = 'User';
        $user->email = 'user@site.dev';
        $user->setPassword('user^^');
        $user->generateAuthKey();
        $user->save();
        $authManager->assign($userRole, $user->id);
    }

    public function safeDown()
    {
        $this->originalMigration->down();

        $this->delete('{{%user}}', [
            ['username' => 'developer'],
            ['username' => 'admin'],
            ['username' => 'manager'],
            ['username' => 'user'],
        ]);
    }
}
