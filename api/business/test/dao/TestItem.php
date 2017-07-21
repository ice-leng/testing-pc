<?php

namespace business\test\dao;

use Yii;

/**
 * This is the model class for table "test_item".
 *
 * @property integer $id
 * @property integer $test_workflow_id
 * @property string  $name
 * @property integer $type
 * @property string  $url
 * @property integer $is_delete
 * @property integer $created_at
 * @property integer $updated_at
 */
class TestItem extends \business\common\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'test_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            [['test_workflow_id', 'type'], 'integer'],
            [['name'], 'string', 'max' => 32],
            [['url'], 'string', 'max' => 255],
            [['url'], 'url', 'defaultScheme' => 'http'],
            [['id', 'url', 'name', 'type', 'test_workflow_id'], 'trim'],
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
            'name'             => '名称',
            'type'             => '访问类型',
            'url'              => '访问网络地址',
            'is_delete'        => '是否删除',
            'created_at'       => '创建时间',
            'updated_at'       => '更新时间',
        ];
    }

    /**
     * 通过测试流程id获得测试流程项信息
     *
     * @param int $workflowId
     *
     * @return mixed
     * @author lengbin(lengbin0@gmail.com)
     */
    public function getTestItemByWorkflowId($workflowId)
    {
        return $this->find()->select([
            'id',
            'test_workflow_id',
            'name',
            'type',
            'url'
        ])->where([
            'test_workflow_id' => $workflowId
        ])->all();
    }

    public function getSetCases()
    {
        return $this->hasMany(TestSetCase::className(), ['test_item_id' => 'id']);
    }

    public function getAccepts()
    {
        return $this->hasMany(TestAccept::className(), ['test_item_id' => 'id']);
    }

    /**
     * 通过流程id 删除 测试项
     *
     * @param int $workflowId 流程id
     *
     * @author lengbin(lengbin0@gmail.com)
     */
    public function deleteTestItem($workflowId)
    {
        TestItem::deleteAll([
            'test_workflow_id' => $workflowId,
        ]);
    }

    /**
     * 添加 测试项
     *
     * @param array $params ['url', 'name', 'type', 'test_workflow_id']
     *
     * @return object
     * @author lengbin(lengbin0@gmail.com)
     */
    public function updateTestItem(array $params)
    {
        $workflowId = isset($params['test_workflow_id']) ? $params['test_workflow_id'] : 0;
        $this->deleteTestItem($workflowId);
        $item = new TestItem();
        $item->setAttributes($params);
        $item->save();
        return $item;
    }
}
