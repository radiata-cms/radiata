<?php

use yii\db\Migration;
use yii\db\Schema;


class m151022_120000_page_init extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%page_page}}', [
            'id'         => Schema::TYPE_PK,
            'status'     => Schema::TYPE_INTEGER . '(2) NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'created_by' => Schema::TYPE_INTEGER,
            'updated_by' => Schema::TYPE_INTEGER,
        ], $tableOptions);

        //fk
        $this->addForeignKey(
            "fk_page_created_by",
            '{{%page_page}}',
            'created_by',
            '{{%radiata_user}}',
            'id',
            'SET NULL',
            'SET NULL'
        );

        //fk
        $this->addForeignKey(
            "fk_page_updated_by",
            '{{%page_page}}',
            'updated_by',
            '{{%radiata_user}}',
            'id',
            'SET NULL',
            'SET NULL'
        );

        $this->createIndex("ix_page_page_status", '{{%page_page}}', ["status"]);


        $this->createTable('{{%page_page_translation}}', [
            'parent_id'        => Schema::TYPE_INTEGER . ' NOT NULL',
            'locale'           => Schema::TYPE_STRING . '(20) NOT NULL',
            'slug'             => Schema::TYPE_STRING . '(100) NOT NULL',
            'title'            => Schema::TYPE_STRING . '(255) NOT NULL',
            'description'      => Schema::TYPE_TEXT,
            'content'          => Schema::TYPE_TEXT,
            'meta_title'       => Schema::TYPE_STRING . '(255)',
            'meta_keywords'    => Schema::TYPE_STRING . '(255)',
            'meta_description' => Schema::TYPE_STRING . '(255)',
        ], $tableOptions);

        //pk
        $this->addPrimaryKey(
            'pk_page_page_translation',
            '{{%page_page_translation}}',
            ['parent_id', 'locale']
        );

        //fk
        $this->addForeignKey(
            "fk_page_page_translation_parent_id",
            '{{%page_page_translation}}',
            'parent_id',
            '{{%page_page}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        //fk
        $this->addForeignKey(
            "fk_page_translation_lang",
            '{{%page_page_translation}}',
            'locale',
            '{{%radiata_lang}}',
            'locale',
            'CASCADE',
            'CASCADE'
        );

        $authManager = Yii::$app->authManager;
        $permissionPageModule = $authManager->createPermission('Pages Module');
        $authManager->add($permissionPageModule);
    }

    public function safeDown()
    {
        $this->dropTable('{{%page_page_translation}}');
        $this->dropTable('{{%page_page}}');
    }
}
