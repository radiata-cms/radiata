<?php

use yii\db\Schema;
use yii\db\Migration;

class m150831_135846_admin_log extends Migration
{

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%radiata_admin_log}}', [
            'id' => $this->primaryKey(),
            'module' => $this->string(255)->notNull(),
            'model' => $this->string(255),
            'action' => $this->string(32)->notNull(),
            'user_id' => $this->integer(),
            'data' => $this->text(),
            'created_at' => $this->integer()->notNull(),
        ], $tableOptions);

        //fk
        $this->addForeignKey(
            "fk_admin_log_user_id",
            '{{%radiata_admin_log}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        //index
        $this->createIndex(
            "in_admin_log_action",
            '{{%radiata_admin_log}}',
            'action'
        );

        //index
        $this->createIndex(
            "in_admin_log_created_at",
            '{{%radiata_admin_log}}',
            'created_at'
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%radiata_admin_log}}');
    }
}
