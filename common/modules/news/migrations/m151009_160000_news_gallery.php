<?php

use yii\db\Migration;
use yii\db\Schema;

class m151009_160000_news_gallery extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }


        /* NEWS */
        $this->createTable('{{%news_gallery}}', [
            'id'        => Schema::TYPE_PK,
            'parent_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'position'  => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 1',
            'image'     => Schema::TYPE_STRING . '(255)',
        ], $tableOptions);

        //fk
        $this->addForeignKey(
            "fk_news_parent_id",
            '{{%news_gallery}}',
            'parent_id',
            '{{%news_news}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createTable('{{%news_gallery_translation}}', [
            'parent_id'  => Schema::TYPE_INTEGER . ' NOT NULL',
            'locale'     => Schema::TYPE_STRING . '(20) NOT NULL',
            'image_text' => Schema::TYPE_TEXT,
        ], $tableOptions);

        //pk
        $this->addPrimaryKey(
            'pk_news_gallery_translation',
            '{{%news_gallery_translation}}',
            ['parent_id', 'locale']
        );

        //fk
        $this->addForeignKey(
            "fk_news_gallery_translation_parent_id",
            '{{%news_gallery_translation}}',
            'parent_id',
            '{{%news_gallery}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        //fk
        $this->addForeignKey(
            "fk_news_gallery_translation_lang",
            '{{%news_gallery_translation}}',
            'locale',
            '{{%radiata_lang}}',
            'locale',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%news_gallery}}');
        $this->dropTable('{{%news_gallery_translation}}');
    }
}
