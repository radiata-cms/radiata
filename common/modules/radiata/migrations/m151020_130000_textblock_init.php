<?php

use yii\db\Migration;
use yii\db\Schema;


class m151020_130000_textblock_init extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%radiata_textblock}}', [
            'id'         => Schema::TYPE_PK,
            'name'       => Schema::TYPE_STRING . '(255) NOT NULL',
            'key'        => Schema::TYPE_STRING . '(255)',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'created_by' => Schema::TYPE_INTEGER,
            'updated_by' => Schema::TYPE_INTEGER,
        ], $tableOptions);

        //key
        $this->createIndex("ix_radiata_textblock_name", '{{%radiata_textblock}}', ['name', 'key'], true);

        //fk
        $this->addForeignKey(
            "fk_radiata_textblock_created_by",
            '{{%radiata_textblock}}',
            'created_by',
            '{{%radiata_user}}',
            'id',
            'SET NULL',
            'SET NULL'
        );

        //fk
        $this->addForeignKey(
            "fk_radiata_textblock_updated_by",
            '{{%radiata_textblock}}',
            'updated_by',
            '{{%radiata_user}}',
            'id',
            'SET NULL',
            'SET NULL'
        );

        $this->createTable('{{%radiata_textblock_translation}}', [
            'parent_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'locale'    => Schema::TYPE_STRING . '(20) NOT NULL',
            'text'      => Schema::TYPE_TEXT,
        ], $tableOptions);

        //pk
        $this->addPrimaryKey(
            'pk_radiata_textblock_translation',
            '{{%radiata_textblock_translation}}',
            ['parent_id', 'locale']
        );

        //fk
        $this->addForeignKey(
            "fk_radiata_textblock_translation_parent_id",
            '{{%radiata_textblock_translation}}',
            'parent_id',
            '{{%radiata_textblock}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        //fk
        $this->addForeignKey(
            "fk_radiata_textblock_translation_lang",
            '{{%radiata_textblock_translation}}',
            'locale',
            '{{%radiata_lang}}',
            'locale',
            'CASCADE',
            'CASCADE'
        );

        $authManager = Yii::$app->authManager;
        $permissionRadiataModuleTextBlocks = $authManager->createPermission('Radiata Module. Text blocks');
        $authManager->add($permissionRadiataModuleTextBlocks);
        $permissionRadiataModule = $authManager->getPermission('Radiata Module');
        $authManager->addChild($permissionRadiataModule, $permissionRadiataModuleTextBlocks);
    }

    public function safeDown()
    {
        $this->dropTable('{{%radiata_textblock_translation}}');
        $this->dropTable('{{%radiata_textblock}}');
    }
}
