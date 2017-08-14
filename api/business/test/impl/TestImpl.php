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
use common\helpers\BaseHelper;
use common\helpers\CodeHelper;
use yii\base\Exception;

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
     * 获得名称
     *
     * @param $isExe
     *
     * @return string
     * @author lengbin(lengbin0@gmail.com)
     */
    protected function getIsExeName($isExe)
    {
        switch ($isExe) {
            case 1:
                $name = '激活';
                break;
            case 2:
                $name = '取消';
                break;
            default:
                $name = '初始化';
                break;
        }
        return $name;
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
        $itemTypes = BaseHelper::getTestItemType(false);
        $workflow = $this->_workFlow->getTestWorkflowList($projectId, $params);
        $testItems = $testItems = $this->getTestItemByProjectId($projectId);
        foreach ($workflow['models'] as $key => $flow) {
            $data = [];
            $items = $this->_item->getTestItemByWorkflowId($flow['id']);
            foreach ($items as $item) {
                $beforeItemName = '';
                if (!empty($item['before_item'])) {
                    $ids = explode(',', $item['before_item']);
                    foreach ($ids as $id) {
                        if (isset($testItems[$id])) {
                            $beforeItemName .= $testItems[$id] . ',';
                        }
                    }
                    $beforeItemName = substr($beforeItemName, 0, -1);
                }
                $data[] = [
                    'name'        => $item->name,
                    'before_item' => $beforeItemName ? $beforeItemName : '无',
                    'type'        => isset($itemTypes[$item->type]) ? $itemTypes[$item->type] : $item->type,
                    'url'         => $item->url ? $item->url : '无',
                ];
            }
            $isExe = isset($flow['is_exe']) ? $flow['is_exe'] : 0;
            $workflow['models'][$key]['items'] = $data;
            $workflow['models'][$key]['is_exe'] = $this->getIsExeName($isExe);
        }
        return $workflow;
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
     * @return object
     * @author lengbin(lengbin0@gmail.com)
     */
    public function getTestWorkflowById($id)
    {
        $workflow = $this->_workFlow->getTestWorkflowById($id);
        if (empty($workflow)) {
            $this->invalidParamException(CodeHelper::SYS_PARAMS_ERROR, '测试流程不存在');
        }
        return $workflow;
    }

    /**
     * 通过测试流程id获得测试流程项信息
     *
     * @param int $workflowId
     * @param int $projectId
     *
     * @return mixed
     * @author lengbin(lengbin0@gmail.com)
     */
    public function getTestItemByWorkflowId($workflowId, $projectId)
    {
        $items = $this->_item->getTestItemByWorkflowId($workflowId);
        $testItems = $testItems = $this->getTestItemByProjectId($projectId);
        foreach ($items as $i => $item) {
            $beforeItem = [];
            if (!empty($item['before_item'])) {
                $ids = explode(',', $item['before_item']);
                foreach ($ids as $id) {
                    if (isset($testItems[$id])) {
                        $beforeItem[$id] = $testItems[$id];
                    }
                }
            }
            $items[$i]['before_item'] = BaseHelper::changeJson($beforeItem);;
        }
        return $items;
    }

    /**
     * 通过测试流程id获得测试流程排序
     *
     * @param int $pid
     * @param int $id
     *
     * @return mixed
     * @author lengbin(lengbin0@gmail.com)
     */
    public function getTestWorkflowOrder($pid, $id = 0)
    {
        if ($id > 0) {
            $workflow = $this->getTestWorkflowById($id);
            $order = $workflow->order;
        } else {
            $workflow = $this->_workFlow->getMaxOrder($pid);
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

    /**
     * 通过项目id 获得所有测试流程
     *
     * @param         array /int $pid project id
     * @param int     $id   item id
     * @param boolean $isFull
     *
     * @return array [ [id => name], ... ]
     * @author lengbin(lengbin0@gmail.com)
     */
    public function getTestItemByProjectId($pid, $id = 0, $isFull = false)
    {
        $testWorkflow = $this->_item->getTestItemByProjectId($pid, $id);
        $data = [];
        foreach ($testWorkflow as $flow) {
            $data[$flow['id']] = $isFull ? $flow : $flow['name'];
        }
        return $data;
    }

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
     * @throws Exception
     */
    public function update(array $params)
    {
        $workflow = [];
        $error = [];
        $flow = isset($params['flow']) ? $params['flow'] : [];
        $items = isset($params['item']) ? $params['item'] : [];
        $setCases = isset($params['setCase']) ? $params['setCase'] : [];
        $accepts = isset($params['accept']) ? $params['accept'] : [];
        $con = \Yii::$app->db->beginTransaction();
        try {
            try {
                $workflow = $this->_workFlow->updateTestWorkflow($flow);
            } catch (Exception $e) {
                if ($e->getCode() === CodeHelper::SYS_PARAMS_ERROR) {
                    throw $e;
                }
                $error['flow'] = $e->getMessage();
            }
            $flowId = isset($workflow['id']) ? $workflow['id'] : 0;
            $testItems = $this->getTestItemByProjectId($flow['project_id']);
            foreach ($items as $i => $item) {
                $itemObj = [];
                $item['project_id'] = $flow['project_id'];
                $item['test_workflow_id'] = $flowId;
                $i = !empty($item['id']) ? $item['id'] : $i;
                try {
                    $itemObj = $this->_item->updateTestItem($item, $testItems);
                } catch (Exception $e) {
                    $error['item'][$i] = $e->getMessage();
                }
                $setCase = isset($setCases[$i]) ? $setCases[$i] : [];
                $acceptes = isset($accepts[$i]) ? $accepts[$i] : [];
                $itemId = isset($itemObj['id']) ? $itemObj['id'] : 0;
                $this->_setCase->deleteTestSetCase($itemId);
                $this->_accept->deleteTestAccept($itemId);
                foreach ($setCase as $m => $case) {
                    $case['test_item_id'] = $itemId;
                    $case['is_required'] = $case['is_required'] ? 1 : 0;
                    $case['is_xss'] = $case['is_xss'] ? 1 : 0;
                    $case['is_sql'] = $case['is_sql'] ? 1 : 0;
                    try {
                        $this->_setCase->updateTestSetCase($case);
                    } catch (Exception $e) {
                        $error['setCase'][$i][$m] = $e->getMessage();
                    }
                }
                foreach ($acceptes as $n => $accept) {
                    $accept['test_item_id'] = $itemId;
                    try {
                        $this->_accept->updateTestAccept($accept);
                    } catch (Exception $e) {
                        $error['accept'][$i][$n] = $e->getMessage();
                    }
                }
            }
            $con->commit();
        } catch (Exception $e) {
            $con->rollBack();
        }
        if (!empty($error)) {
            $this->invalidFormException(CodeHelper::SYS_FORM_ERROR, $error);
        }
        return $workflow;
    }

    /**
     * 是否执行测试
     *
     * @param int $workflowId
     *
     * @return mixed
     * @author lengbin(lengbin0@gmail.com)
     */
    public function isRun($workflowId)
    {
        if (empty($workflowId)) {
            return 0;
        }
        $workflow = $this->getTestWorkflowById($workflowId);
        return $workflow->is_exe;
    }

    /**
     * batch case
     *
     * @param array $data
     * @param int   $isRight
     * @param int   $type
     *
     * @return array
     * @author lengbin(lengbin0@gmail.com)
     */
    private function _getBatchCase($data, $isRight = 0, $type = 0)
    {
        switch ($type) {
            case 1:
                $name = '|不能为空';
                $params = '';
                break;
            case 2:
                $name = '|xss攻击';
                $params = '<img src=”javacript:alert(/XSS/)”></img>';
                break;
            case 3:
                $name = '|sql注入';
                $params = ' or 1=1 ';
                break;
            default:
                $name = '';
                $params = $data['setCase']['element_params'];
                break;
        }
        return [
            $data['workflowId'],
            $data['setCase']['test_item_id'],
            $data['beforeItem'],
            $data['name'] . $name,
            $data['setCase']['element_type'],
            $data['setCase']['event_type'],
            $data['setCase']['element'],
            $params,
            $data['setCase']['wait_time'],
            $isRight,
            0,
            time(),
            time(),
        ];
    }

    /**
     * 修改是否执行状态
     *
     * @param $workflowId
     * @param $status
     *
     * @return object
     * @author lengbin(lengbin0@gmail.com)
     */
    public function changeWorkFlowIsExe($workflowId, $status = null)
    {
        $workflow = $this->getTestWorkflowById($workflowId);
        if ($status !== null) {
            $workflow->is_exe = $status;
        } else {
            if ($workflow->is_exe === 1) {
                $workflow->is_exe = 2;
            } else {
                $workflow->is_exe = 1;
            }
        }
        $workflow->save();
        return $workflow;
    }

    /**
     * 通过流程id 生成测试用例
     *
     * @param int $workflowId
     *
     * @return mixed
     * @author lengbin(lengbin0@gmail.com)
     * @throws \Exception
     */
    public function generateCase($workflowId)
    {
        $cases = [];
        $this->getTestWorkflowById($workflowId);
        $items = $this->_item->getTestItemByWorkflowId($workflowId);
        foreach ($items as $item) {
            $beforeItem = isset($item['before_item']) ? $item['before_item'] : '';
            $setCases = $item->setCases;
            foreach ($setCases as $setCase) {
                $isRequired = $setCase['is_required'] ? 1 : 0;
                $isXss = $setCase['is_xss'] ? 1 : 0;
                $isSql = $setCase['is_sql'] ? 1 : 0;
                $data = [
                    'setCase'    => $setCase,
                    'workflowId' => $workflowId,
                    'beforeItem' => $beforeItem,
                    'name'       => isset($item['name']) ? $item['name'] : '',
                ];
                if ($isRequired) {
                    $cases[] = $this->_getBatchCase($data, 0, 1);
                }
                if ($isXss) {
                    $cases[] = $this->_getBatchCase($data, 0, 2);
                }
                if ($isSql) {
                    $cases[] = $this->_getBatchCase($data, 0, 3);
                }
                $cases[] = $this->_getBatchCase($data, 1);
            }
        }
        $con = \Yii::$app->db->beginTransaction();
        try {
            $this->_case->deleteTestCaseByWorkflowId($workflowId);
            $this->_case->batchAddTestCase($cases);
            $this->changeWorkFlowIsExe($workflowId, 1);
            $con->commit();
        } catch (Exception $e) {
            \Yii::error($e->getMessage());
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * 获得需要执行的测试流程列表
     *
     * @return array
     * @author lengbin(lengbin0@gmail.com)
     */
    public function getExeTestWorkflowList()
    {
        return $this->_workFlow->getExeTestWorkflowList();
    }

    /**
     * 通过流程id 获得测试流程信息
     *
     * @param     array /int $workflowId
     * @param int $isRight
     *
     * @return array|\yii\db\ActiveRecord[]
     * @author lengbin(lengbin0@gmail.com)
     */
    public function getTestCaseByWorkflowId($workflowId, $isRight = 0)
    {
        return $this->_case->getTestCaseByWorkflowId($workflowId, $isRight);
    }

    /**
     * 通过项目id 获得正确的测试流程
     *
     * @param int /array $itemId
     *
     * @return array
     * @author lengbin(lengbin0@gmail.com)
     */
    public function getRightTestCaseByItemId($itemId)
    {
        $data = [];
        $cases = $this->_case->getRightTestCaseByItemId($itemId);
        foreach ($cases as $case) {
            $data[$case['test_item_id']][] = $case;
        }
        return $data;
    }

    /**
     * 通过测试项 获得测试期望
     *
     * @param int /array $itemId
     *
     * @return mixed
     * @author lengbin(lengbin0@gmail.com)
     */
    public function getTestAcceptByItemId($itemId)
    {
        $data = [];
        $accepts = $this->_accept->getTestAcceptByItemId($itemId);
        foreach ($accepts as $accept) {
            $data[$accept['test_item_id']][] = $accept;
        }
        return $data;
    }

    /**
     * 通过id 删除 测试流程
     *
     * @param int $id
     *
     * @return mixed
     * @author lengbin(lengbin0@gmail.com)
     */
    public function deleteTestWorkflowById($id)
    {
        $workflow = $this->getTestWorkflowById($id);
        $workflow->is_delete = 1;
        $workflow->save();
        return $workflow;
    }
}