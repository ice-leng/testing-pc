<?php

namespace business\test\dao;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "test_workflow".
 *
 * @property integer $id
 * @property integer $project_id
 * @property string  $before_flow
 * @property string  $name
 * @property integer $fixed_bug
 * @property integer $total_case
 * @property integer $total_bug
 * @property integer $exe_times
 * @property integer $order
 * @property integer $is_delete
 * @property integer $created_at
 * @property integer $updated_at
 */
class TestWorkflow extends \business\common\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'test_workflow';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id', 'order', 'name'], 'required'],
            [
                [
                    'id',
                    'project_id',
                    'order',
                ],
                'integer',
            ],
            [['before_flow'], 'safe'],
            [['name'], 'string', 'max' => 32],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'project_id'  => '项目id',
            'before_flow' => '前置流程',
            'name'        => '名称',
            'fixed_bug'   => '已修改bug',
            'total_case'  => '总测试用例',
            'total_bug'   => '总bug',
            'exe_times'   => '执行次数',
            'order'       => '排序',
            'is_delete'   => '是否删除',
            'created_at'  => '创建时间',
            'updated_at'  => '更新时间',
        ];
    }

    /**
     * 获得最大排序
     *
     * @return int
     * @author lengbin(lengbin0@gmail.com)
     */
    public function getMaxOrder()
    {
        $query = new Query();
        $order = $query->select("MAX('order')")
            ->from($this->tableName())
            ->one();
        return isset($order['order']) ? $order['order'] : 0;
    }

    /**
     * 通过项目id 获得所有测试流程
     *
     * @param $pid
     *
     * @return mixed
     * @author lengbin(lengbin0@gmail.com)
     */
    public function getTestWorkflowByProjectId($pid)
    {
        return $this->find()->where([
            'project_id' => $pid,
            'is_delete' => 0,
        ])->orderBy('order')->all();
    }

}
