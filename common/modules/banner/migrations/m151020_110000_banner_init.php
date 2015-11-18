<?php

use yii\db\Migration;
use yii\db\Schema;


class m151020_110000_banner_init extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%banner_place}}', [
            'id'    => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . '(255) NOT NULL',
        ]);

        
        $this->createTable('{{%banner_banner}}', [
            'id'         => Schema::TYPE_PK,
            'locale' => Schema::TYPE_STRING . '(20) DEFAULT NULL',
            'place_id'   => Schema::TYPE_INTEGER . " NOT NULL DEFAULT '0'",
            'date_start' => Schema::TYPE_INTEGER,
            'date_end'   => Schema::TYPE_INTEGER,
            'title'      => Schema::TYPE_STRING . '(255)',
            'html'       => Schema::TYPE_TEXT,
            'image'      => Schema::TYPE_STRING . '(255)',
            'link'       => Schema::TYPE_STRING . '(255)',
            'new_wnd'    => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
            'status'     => Schema::TYPE_INTEGER . '(2) NOT NULL',
            'priority'   => Schema::TYPE_INTEGER,
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'created_by' => Schema::TYPE_INTEGER,
            'updated_by' => Schema::TYPE_INTEGER,
        ], $tableOptions);

        //fk
        $this->addForeignKey(
            "fk_banner_created_by",
            '{{%banner_banner}}',
            'created_by',
            '{{%radiata_user}}',
            'id',
            'SET NULL',
            'SET NULL'
        );

        //fk
        $this->addForeignKey(
            "fk_banner_updated_by",
            '{{%banner_banner}}',
            'updated_by',
            '{{%radiata_user}}',
            'id',
            'SET NULL',
            'SET NULL'
        );

        //fk
        $this->addForeignKey(
            "fk_banner_banner_place_id",
            '{{%banner_banner}}',
            'place_id',
            '{{%banner_place}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        //fk
        $this->addForeignKey(
            "fk_banner_banner_locale",
            '{{%banner_banner}}',
            'locale',
            '{{%radiata_lang}}',
            'locale',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex("ix_banner_banner_sort", '{{%banner_banner}}', ["place_id", "status", "priority"]);

        $this->createTable('{{%banner_stat}}', [
            'banner_id' => Schema::TYPE_INTEGER . " NOT NULL DEFAULT '0'",
            'views'     => Schema::TYPE_INTEGER . " NOT NULL DEFAULT '0'",
            'clicks'    => Schema::TYPE_INTEGER . " NOT NULL DEFAULT '0'",
            'ctr'       => Schema::TYPE_DOUBLE . "(10,2) NOT NULL DEFAULT '0'",
        ]);

        //fk
        $this->addForeignKey(
            "fk_banner_stat_banner",
            '{{%banner_stat}}',
            'banner_id',
            '{{%banner_banner}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        //pk
        $this->addPrimaryKey(
            "pk_banner_stat",
            '{{%banner_stat}}',
            'banner_id'
        );

        $authManager = Yii::$app->authManager;
        $permissionBannerModule = $authManager->createPermission('Banners Module');
        $authManager->add($permissionBannerModule);
    }

    public function safeDown()
    {
        $this->dropTable('{{%banner_stat}}');
        $this->dropTable('{{%banner_banner}}');
        $this->dropTable('{{%banner_place}}');

        $authManager = Yii::$app->authManager;
        $permission = $authManager->getPermission('Banners Module');
        $authManager->remove($permission);
    }
}
