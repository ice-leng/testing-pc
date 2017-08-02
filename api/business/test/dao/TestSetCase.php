<?php

namespace business\test\dao;

use Yii;

/**
 * This is the model class for table "test_set_case".
 *
 * @property integer $id
 * @property integer $test_item_id
 * @property string  $before_item
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
            [['event_type', 'element_type', 'element'], 'required'],
            [['test_item_id', 'element_type', 'wait_time', 'is_required', 'is_xss', 'is_sql'], 'integer'],
            [['wait_time'], 'integer', 'min' => 0],
            [['element', 'element_params'], 'string', 'max' => 255],
            [
                [
                    'test_item_id',
                    'element_type',
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
            'element_type'   => '查找类型',
            'event_type'     => '事件类型',
            'element'        => '查找元素',
            'element_params' => '填充数据',
            'wait_time'      => '等待时间',
            'is_required'    => '是否必填',
            'is_xss'         => '是否xss攻击',
            'is_sql'         => '是否sql注入',
            'is_delete'      => '是否删除',
            'created_at'     => '创建时间',
            'updated_at'     => '更新时间',
        ];
    }

    /**
     * 通过测试项id 删除 用例设置
     *
     * @param int $itemId 测试项id
     *
     * @author lengbin(lengbin0@gmail.com)
     */
    public function deleteTestSetCase($itemId)
    {
        TestSetCase::deleteAll([
            'test_item_id' => $itemId,
        ]);
    }

    /**
     * 添加 用例设置
     *
     * @param array $params ['test_item_id',
     *                      'element_type',
     *                      'event_type',
     *                      'element',
     *                      'element_params',
     *                      'wait_time',
     *                      'is_required',
     *                      'is_xss',
     *                      'is_sql',]
     *
     * @return object
     * @author lengbin(lengbin0@gmail.com)
     */
    public function updateTestSetCase(array $params)
    {
        $setCase = new TestSetCase();
        $setCase->setAttributes($params);
        $setCase->save();
        return $setCase;
    }
}
