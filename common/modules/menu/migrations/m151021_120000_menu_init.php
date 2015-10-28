<?php

use yii\db\Migration;
use yii\db\Schema;


class m151021_120000_menu_init extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%menu_menu}}', [
            'id'         => Schema::TYPE_PK,
            'status'     => Schema::TYPE_INTEGER . '(2) NOT NULL',
            'parent_id'  => Schema::TYPE_INTEGER,
            'position'   => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 1',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'created_by' => Schema::TYPE_INTEGER,
            'updated_by' => Schema::TYPE_INTEGER,
        ], $tableOptions);

        //fk
        $this->addForeignKey(
            "fk_menu_menu_parent",
            '{{%menu_menu}}',
            'parent_id',
            '{{%menu_menu}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        //fk
        $this->addForeignKey(
            "fk_menu_created_by",
            '{{%menu_menu}}',
            'created_by',
            '{{%radiata_user}}',
            'id',
            'SET NULL',
            'SET NULL'
        );

        //fk
        $this->addForeignKey(
            "fk_menu_updated_by",
            '{{%menu_menu}}',
            'updated_by',
            '{{%radiata_user}}',
            'id',
            'SET NULL',
            'SET NULL'
        );

        $this->createIndex("ix_menu_menu_status", '{{%menu_menu}}', ["status"]);


        $this->createTable('{{%menu_menu_translation}}', [
            'parent_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'locale'    => Schema::TYPE_STRING . '(20) NOT NULL',
            'title'     => Schema::TYPE_STRING . '(255) NOT NULL',
            'link' => Schema::TYPE_STRING . '(255)',
        ], $tableOptions);

        //pk
        $this->addPrimaryKey(
            'pk_menu_menu_translation',
            '{{%menu_menu_translation}}',
            ['parent_id', 'locale']
        );

        //fk
        $this->addForeignKey(
            "fk_menu_menu_translation_parent_id",
            '{{%menu_menu_translation}}',
            'parent_id',
            '{{%menu_menu}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        //fk
        $this->addForeignKey(
            "fk_menu_translation_lang",
            '{{%menu_menu_translation}}',
            'locale',
            '{{%radiata_lang}}',
            'locale',
            'CASCADE',
            'CASCADE'
        );

        $authManager = Yii::$app->authManager;
        $permissionMenuModule = $authManager->createPermission('Menu Module');
        $authManager->add($permissionMenuModule);
    }

    public function safeDown()
    {
        $this->dropTable('{{%menu_menu_translation}}');
        $this->dropTable('{{%menu_menu}}');

        $authManager = Yii::$app->authManager;
        $permission = $authManager->getPermission('Menu Module');
        $authManager->remove($permission);
    }
}
