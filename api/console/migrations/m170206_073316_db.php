<?php

use yii\db\Migration;

class m170206_073316_db extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%demo}}', [
            'id'         => $this->primaryKey(),
            'name'       => $this->string(32)->notNull()->comment('name'),
            'created_at' => $this->integer()->notNull()->comment('创建时间'),
            'updated_at' => $this->integer()->notNull()->comment('更新时间'),
        ], $tableOptions . ' comment \'demo\'');


    }

    public function down()
    {
        $this->dropTable('{{%demo}}');
    }
}
