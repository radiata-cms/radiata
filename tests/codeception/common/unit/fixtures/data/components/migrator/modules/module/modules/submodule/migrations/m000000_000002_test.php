<?php

use yii\db\Schema;
use yii\db\Migration;

class m000000_000002_test extends Migration
{
    public function safeUp()
    {
        $this->createTable('subtest', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . '(255) NOT NULL',
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('subtest');
    }
}
