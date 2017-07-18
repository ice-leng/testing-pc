<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/7/12
 * Time: 上午11:44
 */

namespace business\test\impl;


use business\common\BaseService;
use business\test\dao\TestAccept;
use business\test\dao\TestCase;
use business\test\dao\TestItem;
use business\test\dao\TestLog;
use business\test\dao\TestSetCase;
use business\test\dao\TestWorkflow;
use business\test\TestInterface;

class TestImpl extends BaseService implements TestInterface
{
    private $_workFlow;
    private $_item;
    private $_case;
    private $_accept;
    private $_log;
    private $_setCase;

    public function __construct(array $config = [])
    {
        $this->_workFlow = new TestWorkflow();
        $this->_item = new TestItem();
        $this->_setCase = new TestSetCase();
        $this->_case = new TestCase();
        $this->_accept = new TestAccept();
        $this->_log = new TestLog();
        parent::__construct($config);
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
        // TODO: Implement getTestWorkflowList() method.
    }

    /**
     * 测试流程列表 表单验证规则
     *
     * @return mixed
     * @author lengbin(lengbin0@gmail.com)
     */
    public function getTestWorkflowFormValidate()
    {
        return $this->createFromValidate($this->_workFlow);
    }

    /**
     * 通过测试流程id获得测试流程信息
     *
     * @param int $id
     *
     * @return mixed
     * @author lengbin(lengbin0@gmail.com)
     */
    public function getTestWorkflowById($id)
    {
        // TODO: Implement getTestWorkflowById() method.
    }

    /**
     * 添加 / 更新 测试流程
     *
     * @param array $params
     *
     * @return mixed
     * @author lengbin(lengbin0@gmail.com)
     */
    public function updateTestWorkflow(array $params)
    {
        // TODO: Implement updateTestWorkflow() method.
    }

    /**
     * 通过测试流程id获得测试流程排序
     *
     * @param int $id
     *
     * @return mixed
     * @author lengbin(lengbin0@gmail.com)
     */
    public function getTestWorkflowOrder($id = 0)
    {
        $order = 0;
        if ($id > 0) {
            $workflow = $this->getTestWorkflowById($id);
            $order = $workflow->order;
        } else {
            $workflow = $this->_workFlow->getMaxOrder();
            $order = $workflow + 1;
        }
        return $order;
    }

    /**
     * 测试项 表单验证规则
     *
     * @return mixed
     * @author lengbin(lengbin0@gmail.com)
     */
    public function getTestItemFormValidate()
    {
        return $this->createFromValidate($this->_item);
    }

    /**
     * 测试设置用例 表单验证规则
     *
     * @return mixed
     * @author lengbin(lengbin0@gmail.com)
     */
    public function getTestSetCaseFormValidate()
    {
        return $this->createFromValidate($this->_setCase);
    }

    /**
     * 测试验收 表单验证规则
     *
     * @return mixed
     * @author lengbin(lengbin0@gmail.com)
     */
    public function getTestAcceptFormValidate()
    {
        return $this->createFromValidate($this->_accept);
    }
}