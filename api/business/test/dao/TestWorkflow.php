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
            [['id', 'project_id', 'before_flow', 'name', 'order'], 'trim'],

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
        $order = $query->select("MAX(`order`) as o")
            ->from($this->tableName())
            ->one();
        return isset($order['o']) ? $order['o'] : 0;
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
            'is_delete'  => 0,
        ])->orderBy('order')->all();
    }

    /**
     * 通过测试流程id获得测试流程信息
     *
     * @param int $id
     *
     * @return object
     * @author lengbin(lengbin0@gmail.com)
     */
    public function getTestWorkflowById($id)
    {
        return $this->find()->select([
            'id',
            'project_id',
            'before_flow',
            'name',
            'order',
        ])->where([
            'id'        => $id,
            'is_delete' => 0,
        ])->one();
    }


    /**
     * 添加 / 更新 测试流程
     *
     * @param array $params ['id', 'project_id', 'before_flow', 'name', 'order']
     * @param array $flows  所有流程
     *
     * @return mixed
     * @author lengbin(lengbin0@gmail.com)
     * @throws Exception
     */
    public function updateTestWorkflow(array $params, $flows)
    {
        if (isset($params['id']) && !empty($params['id'])) {
            $workflow = $this->getTestWorkflowById($params['id']);
            if (empty($workflow)) {
                $this->invalidParamException('测试流程不存在');
            }
        } else {
            $workflow = new TestWorkflow();
            $params['id'] = '';
        }
        if (isset($params['before_flow']) && is_array($params['before_flow'])) {
            $ids = [];
            foreach ($params['before_flow'] as $flow) {
                $id = isset($flow['id']) ? $flow['id'] : 0;
                if (!isset($flows[$id]) || empty($flows[$id])) {
                    $this->invalidParamException("前置流程【{$flow['text']}】不存在");
                }
                $ids[] = $id;
            }
            $bf = implode(',', $ids);
            $params['before_flow'] = $bf;
        }
        $workflow->setAttributes($params);
        $workflow->save();
        return $workflow;
    }

}
