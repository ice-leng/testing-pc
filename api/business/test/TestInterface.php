<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/7/12
 * Time: 上午11:42
 */

namespace business\test;


interface TestInterface
{
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
    public function getTestWorkflowList($projectId, array $params = []);

    /**
     * 测试流程列表 表单验证规则
     *
     * @return mixed
     * @author lengbin(lengbin0@gmail.com)
     */
    public function getTestWorkflowFormValidate();

    /**
     * 通过测试流程id获得测试流程信息
     *
     * @param int $id
     *
     * @return mixed
     * @author lengbin(lengbin0@gmail.com)
     */
    public function getTestWorkflowById($id);

    /**
     * 通过测试流程id获得测试流程项信息
     *
     * @param int $workflowId
     *
     * @return mixed
     * @author lengbin(lengbin0@gmail.com)
     */
    public function getTestItemByWorkflowId($workflowId);

    /**
     * 是否执行测试
     *
     * @param int $workflowId
     *
     * @return mixed
     * @author lengbin(lengbin0@gmail.com)
     */
    public function isRun($workflowId);

    /**
     * 通过项目id 获得所有测试流程
     *
     * @param int $pid project id
     *
     * @return array [ [id => name], ... ]
     * @author lengbin(lengbin0@gmail.com)
     */
    public function getTestWorkflowByProjectId($pid);

    /**
     * 通过测试流程id获得测试流程排序
     *
     * @param int $id
     *
     * @return mixed
     * @author lengbin(lengbin0@gmail.com)
     */
    public function getTestWorkflowOrder($id = 0);

    /**
     * 测试项 表单验证规则
     *
     * @return mixed
     * @author lengbin(lengbin0@gmail.com)
     */
    public function getTestItemFormValidate();

    /**
     * 测试设置用例 表单验证规则
     *
     * @return mixed
     * @author lengbin(lengbin0@gmail.com)
     */
    public function getTestSetCaseFormValidate();

    /**
     * 测试验收 表单验证规则
     *
     * @return mixed
     * @author lengbin(lengbin0@gmail.com)
     */
    public function getTestAcceptFormValidate();

    /**
     * 添加 / 更新 测试流程
     *
     * @param array $params     [
     *                          'flow' => [],
     *                          'item' => [],
     *                          'setCase' => [],
     *                          'accept => []'
     *                          ]
     *
     * @return array
     * @author lengbin(lengbin0@gmail.com)
     */
    public function update(array $params);

    /**
     * 通过流程id 生成测试用例
     *
     * @param int $workflowId
     *
     * @return mixed
     * @author lengbin(lengbin0@gmail.com)
     */
    public function generateCase($workflowId);


}