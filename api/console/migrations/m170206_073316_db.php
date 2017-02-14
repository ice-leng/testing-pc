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

        $this->createTable('{{%project}}', [
            'id'         => $this->primaryKey(),
            'name'       => $this->string(32)->notNull()->comment('项目名称'),
            'url'        => $this->string('255')->notNull()->comment('当前访问网络地址'),
            'browser'    => $this->smallInteger(1)->notNull()->defaultValue(1)->comment('浏览器'),
            'fixed_bug'  => $this->integer()->notNull()->defaultValue(0)->comment('已修改bug'),
            'total_case' => $this->integer()->notNull()->defaultValue(0)->comment('总测试用例'),
            'total_bug'  => $this->integer()->notNull()->defaultValue(0)->comment('总bug'),
            'total_item' => $this->integer()->notNull()->defaultValue(0)->comment('总测试项'),
            'is_delete'  => $this->smallInteger(1)->notNull()->defaultValue(0)->comment('是否删除'),
            'created_at' => $this->integer()->notNull()->comment('创建时间'),
            'updated_at' => $this->integer()->notNull()->comment('更新时间'),
        ], $tableOptions . ' comment \'项目\'');

        $this->createTable('{{%project_url}}', [
            'id'         => $this->primaryKey(),
            'project_id' => $this->integer()->notNull()->comment('项目id'),
            'name'       => $this->string(32)->notNull()->comment('项目名称'),
            'url'        => $this->string('255')->notNull()->comment('访问网络地址'),
            'is_delete'  => $this->smallInteger(1)->notNull()->defaultValue(0)->comment('是否删除'),
            'created_at' => $this->integer()->notNull()->comment('创建时间'),
            'updated_at' => $this->integer()->notNull()->comment('更新时间'),
        ], $tableOptions . ' comment \'项目网络地址\'');
        $this->createIndex('project_id_index', '{{%project_url}}', 'project_id');

        $this->createTable('{{%test_item}}', [
            'id'          => $this->primaryKey(),
            'project_id'  => $this->integer()->notNull()->comment('项目id'),
            'name'        => $this->string(32)->notNull()->comment('名称'),
            'url'         => $this->string('255')->notNull()->comment('访问网络地址'),
            'fixed_bug'   => $this->integer()->notNull()->defaultValue(0)->comment('已修改bug'),
            'total_case'  => $this->integer()->notNull()->defaultValue(0)->comment('总测试用例'),
            'total_bug'   => $this->integer()->notNull()->defaultValue(0)->comment('总bug'),
            'exe_times'   => $this->integer()->notNull()->defaultValue(0)->comment('执行次数'),
            'order'       => $this->integer()->notNull()->defaultValue(0)->comment('排序'),
            'is_exe'      => $this->integer()->notNull()->defaultValue(0)->comment('是否执行'),
            'before_flow' => $this->string(32)->notNull()->comment('前置流程'),
            'after_flow'  => $this->string(32)->notNull()->comment('后置流程'),
            'is_delete'   => $this->smallInteger(1)->notNull()->defaultValue(0)->comment('是否删除'),
            'created_at'  => $this->integer()->notNull()->comment('创建时间'),
            'updated_at'  => $this->integer()->notNull()->comment('更新时间'),
        ], $tableOptions . ' comment \'测试项\'');
        $this->createIndex('project_id_index', '{{%test_item}}', 'project_id');


        $this->createTable('{{%test_case}}', [
            'id'                  => $this->primaryKey(),
            'test_item_id'        => $this->integer()->notNull()->comment('测试项id'),
            'name'                => $this->string(32)->notNull()->comment('名称'),
            'event_name'          => $this->smallInteger(1)->notNull()->defaultValue(2)->comment('事件名称'),
            'find_element_type'   => $this->string('32')->notNull()->comment('查找类型'),
            'find_element'        => $this->string('255')->notNull()->comment('查找元素'),
            'find_element_params' => $this->string('255')->notNull()->comment('查找参数'),
            'wait_time'           => $this->smallInteger(4)->notNull()->defaultValue(10)->comment('等待时间'),
            'is_right'            => $this->smallInteger(1)->notNull()->defaultValue(0)->comment('是否正确'),
            'is_delete'           => $this->smallInteger(1)->notNull()->defaultValue(0)->comment('是否删除'),
            'created_at'          => $this->integer()->notNull()->comment('创建时间'),
            'updated_at'          => $this->integer()->notNull()->comment('更新时间'),
        ], $tableOptions . ' comment \'测试用例\'');
        $this->createIndex('test_item_id_index', '{{%test_case}}', 'test_item_id');


        $this->createTable('{{%test_accept}}', [
            'id'                  => $this->primaryKey(),
            'test_case_id'        => $this->integer()->notNull()->comment('测试用例id'),
            'find_element_type'   => $this->string('32')->notNull()->comment('查找类型'),
            'find_element'        => $this->string('255')->notNull()->comment('查找元素'),
            'find_element_params' => $this->string('255')->notNull()->comment('查找参数'),
            'is_delete'           => $this->smallInteger(1)->notNull()->defaultValue(0)->comment('是否删除'),
            'created_at'          => $this->integer()->notNull()->comment('创建时间'),
            'updated_at'          => $this->integer()->notNull()->comment('更新时间'),
        ], $tableOptions . ' comment \'测试期望\'');
        $this->createIndex('test_case_id_index', '{{%test_accept}}', 'test_case_id');

        $this->createTable('{{%test_log}}', [
            'id'           => $this->primaryKey(),
            'test_case_id' => $this->integer()->notNull()->comment('测试用例id'),
            'name'         => $this->string('32')->notNull()->comment('名称'),
            'status'       => $this->smallInteger(1)->notNull()->comment('状态。1, 通过，2失败'),
            'type'         => $this->smallInteger(1)->notNull()->comment('错误类型'),
            'url'          => $this->string('255')->notNull()->comment('错误截图'),
            'count'        => $this->integer()->notNull()->comment('错误次数'),
            'is_delete'    => $this->smallInteger(1)->notNull()->defaultValue(0)->comment('是否删除'),
            'created_at'   => $this->integer()->notNull()->comment('创建时间'),
            'updated_at'   => $this->integer()->notNull()->comment('更新时间'),
        ], $tableOptions . ' comment \'测试log\'');
        $this->createIndex('test_case_id_index', '{{%test_log}}', 'test_case_id');

        $this->createTable('{{%sys_dict}}', [
            'dict_id'    => $this->string(50)->notNull()->comment('字典英文名称，引用sys_dict_desc.id'),
            'text'       => $this->string(50)->notNull()->comment('字典项文本'),
            'val'        => $this->string(50)->notNull()->comment('字典项值'),
            'sort'       => $this->smallInteger(3)->notNull()->comment('字典项排序'),
            'is_stop'    => $this->smallInteger(1)->notNull()->comment('是否停用，0否，1是'),
            'created_at' => $this->integer()->notNull()->comment('创建时间'),
        ], $tableOptions . ' comment \'字典配置表\'');

        $this->createTable("{{%sys_dict_desc}}", [
            'id'         => $this->string(50)->notNull()->comment('字典英文名称'),
            'text'       => $this->string(50)->notNull()->comment('字典的描述'),
            'val'        => $this->string(50)->notNull()->comment('值的描述'),
            'is_stop'    => $this->smallInteger(1)->notNull()->defaultValue(0)->comment('是否停用，0否，1是'),
            'created_at' => $this->integer()->notNull(),
        ], $tableOptions . " COMMENT='字典配置描述表'");
        $this->createIndex('sys_dict_desc_UK', '{{%sys_dict_desc}}', 'id', true);

        $this->createTable('{{%sys_params}}', [
            'id'             => $this->integer()->notNull(),
            'name'           => $this->string(32)->notNull()->comment('参数名称'),
            'description'    => $this->string(255)->notNull()->comment('说明'),
            'val'            => $this->string(255)->notNull()->comment('值'),
            'display_edited' => $this->smallInteger(1)->notNull()->comment('是否页面展示'),
            'reg_exp'        => $this->string(100)->notNull()->comment('如果可以提供在页面修改，则校验修改的正则表达式'),
            'is_stop'        => $this->smallInteger(1)->notNull()->comment('是否停用，0否，1是'),
            'created_at'     => $this->integer()->notNull(),
            'updated_at'     => $this->integer()->notNull(),
        ], $tableOptions . ' comment \'系统配置参数\'');


    }

    public function down()
    {
        $this->dropTable('{{%demo}}');
        $this->dropTable('{{%project}}');
        $this->dropTable('{{%project_url}}');
        $this->dropTable('{{%test_item}}');
        $this->dropTable('{{%test_case}}');
        $this->dropTable('{{%test_accept}}');
        $this->dropTable('{{%test_log}}');
        $this->dropTable('{{%sys_dict}}');
        $this->dropTable('{{%sys_dict_desc}}');
        $this->dropTable('{{%sys_params}}');
    }
}
