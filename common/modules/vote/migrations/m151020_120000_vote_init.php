<?php

use yii\db\Migration;
use yii\db\Schema;


class m151020_120000_vote_init extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%vote_vote}}', [
            'id'            => Schema::TYPE_PK,
            'date_start'    => Schema::TYPE_INTEGER,
            'date_end'      => Schema::TYPE_INTEGER,
            'status'        => Schema::TYPE_INTEGER . '(2) NOT NULL',
            'type'          => Schema::TYPE_INTEGER . '(3) NOT NULL DEFAULT "1"',
            'total_votes'   => Schema::TYPE_INTEGER . " NOT NULL DEFAULT '0'",
            'total_answers' => Schema::TYPE_INTEGER . " NOT NULL DEFAULT '0'",
            'created_at'    => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at'    => Schema::TYPE_INTEGER . ' NOT NULL',
            'created_by'    => Schema::TYPE_INTEGER,
            'updated_by'    => Schema::TYPE_INTEGER,
        ], $tableOptions);

        //fk
        $this->addForeignKey(
            "fk_vote_created_by",
            '{{%vote_vote}}',
            'created_by',
            '{{%radiata_user}}',
            'id',
            'SET NULL',
            'SET NULL'
        );

        //fk
        $this->addForeignKey(
            "fk_vote_updated_by",
            '{{%vote_vote}}',
            'updated_by',
            '{{%radiata_user}}',
            'id',
            'SET NULL',
            'SET NULL'
        );

        $this->createIndex("ix_vote_vote_status", '{{%vote_vote}}', ["status"]);


        $this->createTable('{{%vote_vote_translation}}', [
            'parent_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'locale'    => Schema::TYPE_STRING . '(20) NOT NULL',
            'title'     => Schema::TYPE_STRING . '(255) NOT NULL',
        ], $tableOptions);

        //pk
        $this->addPrimaryKey(
            'pk_vote_vote_translation',
            '{{%vote_vote_translation}}',
            ['parent_id', 'locale']
        );

        //fk
        $this->addForeignKey(
            "fk_vote_vote_translation_parent_id",
            '{{%vote_vote_translation}}',
            'parent_id',
            '{{%vote_vote}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        //fk
        $this->addForeignKey(
            "fk_vote_translation_lang",
            '{{%vote_vote_translation}}',
            'locale',
            '{{%radiata_lang}}',
            'locale',
            'CASCADE',
            'CASCADE'
        );


        $this->createTable('{{%vote_option}}', [
            'id'          => Schema::TYPE_PK,
            'parent_id'   => Schema::TYPE_INTEGER . " NOT NULL DEFAULT '0'",
            'position'    => Schema::TYPE_INTEGER . " NOT NULL DEFAULT '0'",
            'total_votes' => Schema::TYPE_INTEGER . " NOT NULL DEFAULT '0'",
            'percent'     => Schema::TYPE_DOUBLE . "(5,2) NOT NULL DEFAULT '0.00'",
        ]);

        //fk
        $this->addForeignKey(
            "fk_vote_option_parent_id",
            '{{%vote_option}}',
            'parent_id',
            '{{%vote_vote}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex("ix_vote_option_order", '{{%vote_option}}', ["parent_id", "position"]);


        $this->createTable('{{%vote_option_translation}}', [
            'parent_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'locale'    => Schema::TYPE_STRING . '(20) NOT NULL',
            'title'     => Schema::TYPE_STRING . '(255) NOT NULL',
        ], $tableOptions);

        //pk
        $this->addPrimaryKey(
            'pk_vote_option_translation',
            '{{%vote_option_translation}}',
            ['parent_id', 'locale']
        );

        //fk
        $this->addForeignKey(
            "fk_vote_option_translation_parent_id",
            '{{%vote_option_translation}}',
            'parent_id',
            '{{%vote_option}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        //fk
        $this->addForeignKey(
            "fk_vote_option_translation_lang",
            '{{%vote_option_translation}}',
            'locale',
            '{{%radiata_lang}}',
            'locale',
            'CASCADE',
            'CASCADE'
        );


        $this->createTable('{{%vote_log}}', [
            'option_id' => Schema::TYPE_INTEGER . " NOT NULL DEFAULT '0'",
            'vote_id'   => Schema::TYPE_INTEGER . " NOT NULL DEFAULT '0'",
            'date'      => Schema::TYPE_INTEGER . " NOT NULL",
            'ip'        => Schema::TYPE_BIGINT . "(20)",
        ]);

        //fk
        $this->addForeignKey(
            "fk_vote_log_option_id",
            '{{%vote_log}}',
            'option_id',
            '{{%vote_option}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        //fk
        $this->addForeignKey(
            "fk_vote_log_vote_id",
            '{{%vote_log}}',
            'vote_id',
            '{{%vote_vote}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        //pk
        $this->addPrimaryKey(
            "pk_vote_vote_log",
            '{{%vote_log}}',
            ['option_id', 'ip']
        );

        //key
        $this->createIndex("ix_vote_log_vote", '{{%vote_log}}', ['vote_id', 'ip']);
    }

    public function safeDown()
    {
        $this->dropTable('{{%vote_log}}');
        $this->dropTable('{{%vote_option_translation}}');
        $this->dropTable('{{%vote_option}}');
        $this->dropTable('{{%vote_vote_translation}}');
        $this->dropTable('{{%vote_vote}}');
    }
}
