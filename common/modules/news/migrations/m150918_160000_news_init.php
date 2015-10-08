<?php

use yii\db\Migration;
use yii\db\Schema;

class m150918_160000_news_init extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }


        /* NEWS */
        $this->createTable('{{%news_news}}', [
            'id'                => Schema::TYPE_PK,
            'date'              => Schema::TYPE_INTEGER . ' NOT NULL',
            'category_id'       => Schema::TYPE_INTEGER . ' NOT NULL',
            'status'            => Schema::TYPE_INTEGER . '(2) NOT NULL',
            'image'             => Schema::TYPE_STRING . '(255)',
            'created_at'        => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at'        => Schema::TYPE_INTEGER . ' NOT NULL',
            'created_by'        => Schema::TYPE_INTEGER,
            'updated_by'        => Schema::TYPE_INTEGER,
        ], $tableOptions);

        //fk
        $this->addForeignKey(
            "fk_news_created_by",
            '{{%news_news}}',
            'created_by',
            '{{%radiata_user}}',
            'id',
            'SET NULL',
            'SET NULL'
        );

        //fk
        $this->addForeignKey(
            "fk_news_updated_by",
            '{{%news_news}}',
            'updated_by',
            '{{%radiata_user}}',
            'id',
            'SET NULL',
            'SET NULL'
        );

        $this->createTable('{{%news_news_translation}}', [
            'parent_id'        => Schema::TYPE_INTEGER . ' NOT NULL',
            'locale'           => Schema::TYPE_STRING . '(20) NOT NULL',
            'slug'             => Schema::TYPE_STRING . '(100) NOT NULL',
            'title'            => Schema::TYPE_STRING . '(255) NOT NULL',
            'description'      => Schema::TYPE_TEXT,
            'content'          => Schema::TYPE_TEXT,
            'image_description' => Schema::TYPE_STRING . '(255)',
            'redirect'          => Schema::TYPE_STRING . '(255)',
            'meta_title'       => Schema::TYPE_STRING . '(255)',
            'meta_keywords'    => Schema::TYPE_STRING . '(255)',
            'meta_description' => Schema::TYPE_STRING . '(255)',
        ], $tableOptions);

        //pk
        $this->addPrimaryKey(
            'pk_news_news_translation',
            '{{%news_news_translation}}',
            ['parent_id', 'locale']
        );

        //fk
        $this->addForeignKey(
            "fk_news_news_translation_parent_id",
            '{{%news_news_translation}}',
            'parent_id',
            '{{%news_news}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        //fk
        $this->addForeignKey(
            "fk_news_translation_lang",
            '{{%news_news_translation}}',
            'locale',
            '{{%radiata_lang}}',
            'locale',
            'CASCADE',
            'CASCADE'
        );

        /* CATEGORIES */
        $this->createTable('{{%news_category}}', [
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
            "fk_news_category",
            '{{%news_news}}',
            'category_id',
            '{{%news_category}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        //fk
        $this->addForeignKey(
            "fk_news_category_parent",
            '{{%news_category}}',
            'parent_id',
            '{{%news_category}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        //fk
        $this->addForeignKey(
            "fk_news_category_created_by",
            '{{%news_category}}',
            'created_by',
            '{{%radiata_user}}',
            'id',
            'SET NULL',
            'SET NULL'
        );

        //fk
        $this->addForeignKey(
            "fk_news_category_updated_by",
            '{{%news_category}}',
            'updated_by',
            '{{%radiata_user}}',
            'id',
            'SET NULL',
            'SET NULL'
        );

        $this->createTable('{{%news_category_translation}}', [
            'parent_id'        => Schema::TYPE_INTEGER . ' NOT NULL',
            'locale'           => Schema::TYPE_STRING . '(20) NOT NULL',
            'slug'             => Schema::TYPE_STRING . '(100) NOT NULL',
            'title'            => Schema::TYPE_STRING . '(255) NOT NULL',
            'meta_title'       => Schema::TYPE_STRING . '(255)',
            'meta_keywords'    => Schema::TYPE_STRING . '(255)',
            'meta_description' => Schema::TYPE_STRING . '(255)',
        ], $tableOptions);

        //pk
        $this->addPrimaryKey(
            'pk_news_category_translation',
            '{{%news_category_translation}}',
            ['parent_id', 'locale']
        );

        //fk
        $this->addForeignKey(
            "fk_news_translation_parent_id",
            '{{%news_category_translation}}',
            'parent_id',
            '{{%news_category}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        //fk
        $this->addForeignKey(
            "fk_news_category_translation_lang",
            '{{%news_category_translation}}',
            'locale',
            '{{%radiata_lang}}',
            'locale',
            'CASCADE',
            'CASCADE'
        );


        /* NEWS CATEGORIES */
        $this->createTable('{{%news_news_category}}', [
            'news_id'     => Schema::TYPE_INTEGER . ' NOT NULL',
            'category_id' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        //pk
        $this->addPrimaryKey(
            'pk_news_news_category',
            '{{%news_news_category}}',
            ['news_id', 'category_id']
        );

        //fk
        $this->addForeignKey(
            "fk_news_news_category_news_id",
            '{{%news_news_category}}',
            'news_id',
            '{{%news_news}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        //fk
        $this->addForeignKey(
            "fk_news_news_category_category_id",
            '{{%news_news_category}}',
            'category_id',
            '{{%news_category}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%news_news_category}}');
        $this->dropTable('{{%news_category_translation}}');
        $this->dropTable('{{%news_news_translation}}');
        $this->dropTable('{{%news_news}}');
        $this->dropTable('{{%news_category}}');
    }
}
