<?php

namespace business\test\dao;

use business\project\dao\Project;
use Yii;
use yii\db\Query;

/**
 * This is the model class for table "test_workflow".
 *
 * @property integer $id
 * @property integer $project_id
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
            [['name'], 'string', 'max' => 32],
            [['id', 'project_id', 'name', 'order'], 'trim'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'project_id' => '项目id',
            'name'       => '名称',
            'fixed_bug'  => '已修改bug',
            'total_case' => '总测试用例',
            'total_bug'  => '总bug',
            'exe_times'  => '执行次数',
            'order'      => '排序',
            'is_exe'     => '是否执行',
            'is_delete'  => '是否删除',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * 获得最大排序
     *
     * @param int $pid
     *
     * @return int
     * @author lengbin(lengbin0@gmail.com)
     */
    public function getMaxOrder($pid)
    {
        $query = new Query();
        $order = $query->select("MAX(`order`) as o")
            ->from($this->tableName())
            ->where(['is_delete' => 0, 'project_id' => $pid])
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
            'name',
            'is_exe',
            'order',
        ])->where([
            'id'        => $id,
            'is_delete' => 0,
        ])->one();
    }

    /**
     * 获得需要执行的测试流程列表
     *
     * @return array
     * @author lengbin(lengbin0@gmail.com)
     */
    public function getExeTestWorkflowList()
    {
        return $this->find()->leftJoin(Project::tableName(), Project::tableName() . '.id = ' . $this->tableName() . '.project_id')->where([
            $this->tableName() . '.is_delete'   => 0,
            Project::tableName() . '.is_delete' => 0,
            $this->tableName() . '.is_exe'      => 1,
        ])->all();
    }

    /**
     * 获得测试流程列表
     *
     * @param int   $projectId 项目id
     * @param array $params    ['name' => 'xxx']
     *
     * @return mixed [
     *                  [
     *
     *                  ],
     *              ]
     *
     * @author lengbin(lengbin0@gmail.com)
     */
    public function getTestWorkflowList($projectId, array $params = [])
    {
        $query = new Query();
        $query->select([
            'id',
            'name',
            'fixed_bug',
            'total_case',
            'total_bug',
            'order',
            'is_exe',
        ])
            ->from($this->tableName())
            ->where(['project_id' => $projectId, 'is_delete' => 0]);
        if (isset($params['name']) && !empty($params['name'])) {
            $query->andWhere(['like', 'name', $params['name']]);
        }
        $query->orderBy('order');
        return $this->page($query);
    }

    public function getCases()
    {
        return $this->hasMany(TestCase::className(), ['test_workflow_id' => 'id']);
    }

    /**
     * 添加 / 更新 测试流程
     *
     * @param array $params ['id', 'project_id', 'name', 'order']
     *
     * @return mixed
     * @author lengbin(lengbin0@gmail.com)
     * @throws Exception
     */
    public function updateTestWorkflow(array $params)
    {
        if (isset($params['id']) && !empty($params['id'])) {
            $workflow = $this->getTestWorkflowById($params['id']);
            if (empty($workflow)) {
                $this->invalidParamException('测试流程不存在');
            }
        } else {
            $workflow = new TestWorkflow();
            $params['id'] = '';
            $params['is_exe'] = 2;
        }
        $workflow->setAttributes($params);
        $workflow->save();
        return $workflow;
    }
}
