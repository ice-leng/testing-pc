<?php

namespace business\test\dao;

use Yii;

/**
 * This is the model class for table "test_case".
 *
 * @property integer $id
 * @property integer $test_workflow_id
 * @property integer $test_item_id
 * @property string  $name
 * @property integer $element_type
 * @property string  $element
 * @property string  $element_params
 * @property integer $wait_time
 * @property integer $is_right
 * @property integer $is_delete
 * @property integer $created_at
 * @property integer $updated_at
 */
class TestCase extends \business\common\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'test_case';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['test_workflow_id', 'test_item_id', 'event_type', 'name', 'element'],
                'required',
            ],
            [
                [
                    'test_workflow_id',
                    'test_item_id',
                    'element_type',
                    'event_type',
                    'wait_time',
                    'is_right',
                    'is_delete',
                    'created_at',
                    'updated_at',
                ],
                'integer',
            ],
            [['name'], 'string', 'max' => 32],
            [['element', 'element_params'], 'string', 'max' => 255],
            [
                [
                    'id',
                    'test_workflow_id',
                    'test_item_id',
                    'name',
                    'element_type',
                    'event_type',
                    'element',
                    'element_params',
                    'wait_time',
                    'is_right',
                    'is_delete',
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
            'id'               => 'ID',
            'test_workflow_id' => '流程id',
            'test_item_id'     => '测试项id',
            'name'             => '名称',
            'element_type'     => '查找类型',
            'event_type'       => '事件类型',
            'element'          => '查找元素',
            'element_params'   => '填充数据',
            'wait_time'        => '等待时间',
            'is_right'         => '是否正确',
            'is_delete'        => '是否删除',
            'created_at'       => '创建时间',
            'updated_at'       => '更新时间',
        ];
    }

    /**
     * 通过流程id 获得测试流程信息
     *
     * @param int $workflowId
     *
     * @return array|\yii\db\ActiveRecord[]
     * @author lengbin(lengbin0@gmail.com)
     */
    public function getTestCaseByWorkflowId($workflowId)
    {
        return $this->find()->where([
            'test_workflow_id' => $workflowId,
        ])->all();
    }

    /**
     * 删除 测试流程
     *
     * @param int $workflowId
     *
     * @author lengbin(lengbin0@gmail.com)
     */
    public function deleteTestCaseByWorkflowId($workflowId)
    {
        TestCase::deleteAll([
            'test_workflow_id' => $workflowId,
        ]);
    }

    /**
     * 批量添加 测试用例
     *
     * @param array $params
     *
     * @return array|int
     * @throws \yii\db\Exception
     * @author lengbin(lengbin0@gmail.com)
     */
    public function batchAddTestCase(array $params)
    {
        if (empty($params)) {
            return $params;
        }
        return Yii::$app->db->createCommand()->batchInsert($this->tableName(), [
            'test_workflow_id',
            'test_item_id',
            'name',
            'element_type',
            'event_type',
            'element',
            'element_params',
            'wait_time',
            'is_right',
            'is_delete',
            'created_at',
            'updated_at',
        ], $params)->execute();
    }

}
