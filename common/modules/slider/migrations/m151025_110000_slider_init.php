<?php

use yii\db\Migration;
use yii\db\Schema;


class m151025_110000_slider_init extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%slider_slider}}', [
            'id'    => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . '(255) NOT NULL',
        ]);

        
        $this->createTable('{{%slider_slide}}', [
            'id'         => Schema::TYPE_PK,
            'slider_id'  => Schema::TYPE_INTEGER . " NOT NULL DEFAULT '0'",
            'image'      => Schema::TYPE_STRING . '(255)',
            'status'     => Schema::TYPE_INTEGER . '(2) NOT NULL',
            'position'   => Schema::TYPE_INTEGER,
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'created_by' => Schema::TYPE_INTEGER,
            'updated_by' => Schema::TYPE_INTEGER,
        ], $tableOptions);

        //fk
        $this->addForeignKey(
            "fk_slide_created_by",
            '{{%slider_slide}}',
            'created_by',
            '{{%radiata_user}}',
            'id',
            'SET NULL',
            'SET NULL'
        );

        //fk
        $this->addForeignKey(
            "fk_slide_updated_by",
            '{{%slider_slide}}',
            'updated_by',
            '{{%radiata_user}}',
            'id',
            'SET NULL',
            'SET NULL'
        );

        //fk
        $this->addForeignKey(
            "fk_slider_slide_slider_id",
            '{{%slider_slide}}',
            'slider_id',
            '{{%slider_slider}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex("ix_slide_slide_sort", '{{%slider_slide}}', ["slider_id", "status", "position"]);


        $this->createTable('{{%slider_slide_translation}}', [
            'parent_id'   => Schema::TYPE_INTEGER . ' NOT NULL',
            'locale'      => Schema::TYPE_STRING . '(20) NOT NULL',
            'title'       => Schema::TYPE_STRING . '(255) NOT NULL',
            'description' => Schema::TYPE_STRING . '(255) NOT NULL',
            'link'        => Schema::TYPE_STRING . '(255) NOT NULL',
        ], $tableOptions);

        //pk
        $this->addPrimaryKey(
            'pk_slider_slide_translation',
            '{{%slider_slide_translation}}',
            ['parent_id', 'locale']
        );

        //fk
        $this->addForeignKey(
            "fk_slider_slide_translation_parent_id",
            '{{%slider_slide_translation}}',
            'parent_id',
            '{{%slider_slide}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        //fk
        $this->addForeignKey(
            "fk_slider_translation_lang",
            '{{%slider_slide_translation}}',
            'locale',
            '{{%radiata_lang}}',
            'locale',
            'CASCADE',
            'CASCADE'
        );

        $authManager = Yii::$app->authManager;
        $permissionSlideModule = $authManager->createPermission('Sliders Module');
        $authManager->add($permissionSlideModule);
    }

    public function safeDown()
    {
        $this->dropTable('{{%slider_slide_translation}}');
        $this->dropTable('{{%slider_slide}}');
        $this->dropTable('{{%slider_slider}}');

        $authManager = Yii::$app->authManager;
        $permissionSlideModule = $authManager->getPermission('Sliders Module');
        $authManager->remove($permissionSlideModule);
    }
}
