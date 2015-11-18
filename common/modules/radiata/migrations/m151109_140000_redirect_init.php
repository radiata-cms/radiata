<?php

use yii\db\Migration;
use yii\db\Schema;


class m151109_140000_redirect_init extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%radiata_redirect}}', [
            'id'         => Schema::TYPE_PK,
            'old_url'    => Schema::TYPE_STRING . "(255)",
            'new_url'    => Schema::TYPE_STRING . "(255)",
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'created_by' => Schema::TYPE_INTEGER,
            'updated_by' => Schema::TYPE_INTEGER,
        ], $tableOptions);

        //key
        $this->createIndex("ix_radiata_old_url", '{{%radiata_redirect}}', ['old_url'], true);

        $authManager = Yii::$app->authManager;
        $permissionRadiataModuleRedirects = $authManager->createPermission('Radiata Module. Redirects');
        $authManager->add($permissionRadiataModuleRedirects);
        $permissionRadiataModule = $authManager->getPermission('Radiata Module');
        $authManager->addChild($permissionRadiataModule, $permissionRadiataModuleRedirects);
    }

    public function safeDown()
    {
        $this->dropTable('{{%radiata_redirect}}');

        $authManager = Yii::$app->authManager;
        $permission = $authManager->getPermission('Radiata Module. Redirects');
        $authManager->remove($permission);
    }
}
