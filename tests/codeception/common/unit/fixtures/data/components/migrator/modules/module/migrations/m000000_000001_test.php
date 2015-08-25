<?php

use yii\db\Migration;

class m000000_000001_test extends Migration
{
    public function safeUp()
    {
        $this->batchInsert('test',
            ['name'],
            [
                ['test_name1'],
                ['test_name2'],
            ]
        );
    }

    public function safeDown()
    {
        $this->delete('test');
    }
}
