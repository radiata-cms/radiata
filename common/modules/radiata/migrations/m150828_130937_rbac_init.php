<?php

use common\models\User;
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

        $adminRole = $authManager->createRole('admin');
        $managerRole = $authManager->createRole('manager');
        $userRole = $authManager->createRole('user');

        $authManager->add($adminRole);
        $authManager->add($managerRole);
        $authManager->add($userRole);

        $authManager->addChild($managerRole, $userRole);
        $authManager->addChild($adminRole, $managerRole);

        $user = new User();
        $user->username = 'admin';
        $user->email = 'admin@test.dev';
        $user->setPassword('admin^^');
        $user->generateAuthKey();
        $user->save();

        $authManager->assign($adminRole, $user->id);

        $user = new User();
        $user->username = 'manager';
        $user->email = 'manager@test.dev';
        $user->setPassword('manager^^');
        $user->generateAuthKey();
        $user->save();

        $authManager->assign($managerRole, $user->id);

        $user = new User();
        $user->username = 'user';
        $user->email = 'user@test.dev';
        $user->setPassword('user^^');
        $user->generateAuthKey();
        $user->save();

        $authManager->assign($userRole, $user->id);
    }

    public function safeDown()
    {
        $this->originalMigration->down();

        $this->delete('{{%user}}', [
            ['username' => 'admin'],
            ['username' => 'manager'],
            ['username' => 'user'],
        ]);
    }
}
