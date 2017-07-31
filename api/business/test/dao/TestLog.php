<?php

namespace business\test\dao;

use Yii;

/**
 * This is the model class for table "test_log".
 *
 * @property integer $id
 * @property integer $test_case_id
 * @property string  $name
 * @property integer $status
 * @property integer $type
 * @property string  $url
 * @property integer $count
 * @property integer $is_delete
 * @property integer $created_at
 * @property integer $updated_at
 */
class TestLog extends \business\common\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'test_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['test_case_id', 'name', 'status', 'type'], 'required'],
            [['test_case_id', 'status', 'type', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 32],
            [['url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'           => 'ID',
            'test_case_id' => '测试用例id',
            'name'         => '名称',
            'status'       => '状态。1, 通过，2失败',
            'type'         => '错误类型',
            'url'          => '错误截图',
            'created_at'   => '创建时间',
            'updated_at'   => '更新时间',
        ];
    }
}
