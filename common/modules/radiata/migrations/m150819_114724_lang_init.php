<?php

use yii\db\Migration;
use yii\db\Schema;

class m150819_114724_lang_init extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%radiata_lang}}', [
            'id'       => Schema::TYPE_PK,
            'code'     => Schema::TYPE_STRING . '(2) NOT NULL',
            'locale'   => Schema::TYPE_STRING . '(20) NOT NULL',
            'name'     => Schema::TYPE_STRING . '(255) NOT NULL',
            'default'  => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
            'position' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        //index
        $this->createIndex(
            "in_lang_code",
            '{{%radiata_lang}}',
            'code'
        );

        //index
        $this->createIndex(
            "in_lang_locale",
            '{{%radiata_lang}}',
            'locale',
            true
        );

        $this->batchInsert('{{%radiata_lang}}', ['code', 'locale', 'name', 'default', 'position', 'updated_at', 'created_at'], [
            ['en', 'en-US', 'English', 1, 1, time(), time()],
            ['ru', 'ru-RU', 'Русский', 0, 2, time(), time()],
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%radiata_lang}}');
    }
}
