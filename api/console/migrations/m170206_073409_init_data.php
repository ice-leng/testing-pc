<?php

use yii\db\Migration;

class m170206_073409_init_data extends Migration
{
    public function up()
    {

        $this->batchInsert('{{%demo}}', [
            'id',
            'name',
            'created_at',
            'updated_at',
        ], [
            [
                1,
                'hello world!',
                time(),
                time(),
            ],
        ]);

    }

    public function down()
    {
        $this->truncateTable('{{%demo}}');
    }

}
