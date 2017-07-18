<?php

namespace business\test\dao;

use Yii;

/**
 * This is the model class for table "test_set_case".
 *
 * @property integer $id
 * @property integer $test_item_id
 * @property string  $name
 * @property integer $element_type
 * @property string  $element
 * @property string  $element_params
 * @property integer $wait_time
 * @property integer $is_required
 * @property integer $is_xss
 * @property integer $is_sql
 * @property integer $is_delete
 * @property integer $created_at
 * @property integer $updated_at
 */
class TestSetCase extends \business\common\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'test_set_case';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'event_type', 'element_type', 'element', 'element_params', 'event_params'], 'required'],
            [['test_item_id', 'element_type', 'wait_time', 'is_required', 'is_xss', 'is_sql'], 'integer'],
            [['name'], 'string', 'max' => 32],
            [['element', 'element_params', 'event_params'], 'string', 'max' => 255],
            [
                [
                    'id',
                    'test_item_id',
                    'name',
                    'element_type',
                    'event_params',
                    'event_type',
                    'element',
                    'element_params',
                    'wait_time',
                    'is_required',
                    'is_xss',
                    'is_sql',
                ],
                'trim',
            ],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'             => 'ID',
            'test_item_id'   => '测试项id',
            'name'           => '名称',
            'element_type'   => '查找类型',
            'event_type'     => '事件类型',
            'event_params'   => '事件参数',
            'element'        => '查找元素',
            'element_params' => '参数',
            'wait_time'      => '等待时间',
            'is_required'    => '是否需要',
            'is_xss'         => '是否xss攻击',
            'is_sql'         => '是否sql注入',
            'is_delete'      => '是否删除',
            'created_at'     => '创建时间',
            'updated_at'     => '更新时间',
        ];
    }
}
