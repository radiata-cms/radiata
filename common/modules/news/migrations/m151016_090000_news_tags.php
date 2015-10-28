<?php

use yii\db\Migration;
use yii\db\Schema;

class m151016_090000_news_tags extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }


        /* NEWS */
        $this->createTable('{{%news_tags}}', [
            'id'        => Schema::TYPE_PK,
            'frequency' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
        ], $tableOptions);

        $this->createTable('{{%news_tags_translation}}', [
            'parent_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'locale'    => Schema::TYPE_STRING . '(20) NOT NULL',
            'name'      => Schema::TYPE_STRING . '(255) NOT NULL',
        ], $tableOptions);

        //pk
        $this->addPrimaryKey(
            'pk_news_tags_translation',
            '{{%news_tags_translation}}',
            ['parent_id', 'locale']
        );

        //fk
        $this->addForeignKey(
            "fk_news_tags_translation_parent_id",
            '{{%news_tags_translation}}',
            'parent_id',
            '{{%news_tags}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        //fk
        $this->addForeignKey(
            "fk_news_tags_translation_lang",
            '{{%news_tags_translation}}',
            'locale',
            '{{%radiata_lang}}',
            'locale',
            'CASCADE',
            'CASCADE'
        );

        /* NEWS TAGS ASSIGNMENT */
        $this->createTable('{{%news_news_tags}}', [
            'news_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'tag_id'  => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        //pk
        $this->addPrimaryKey(
            'pk_news_news_tags',
            '{{%news_news_tags}}',
            ['news_id', 'tag_id']
        );

        //fk
        $this->addForeignKey(
            "fk_news_news_tags_news_id",
            '{{%news_news_tags}}',
            'news_id',
            '{{%news_news}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        //fk
        $this->addForeignKey(
            "fk_news_news_tags_tag_id",
            '{{%news_news_tags}}',
            'tag_id',
            '{{%news_tags}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $authManager = Yii::$app->authManager;
        $permissionNewsModule = $authManager->getPermission('News Module');

        $permissionNewsModuleTags = $authManager->createPermission('News Module. Tags');
        $authManager->add($permissionNewsModuleTags);
        $authManager->addChild($permissionNewsModule, $permissionNewsModuleTags);
    }

    public function safeDown()
    {
        $this->dropTable('{{%news_tags_translation}}');
        $this->dropTable('{{%news_tags}}');

        $authManager = Yii::$app->authManager;
        $permission = $authManager->getPermission('News Module. Tags');
        $authManager->remove($permission);
    }
}
