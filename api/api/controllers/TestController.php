<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/7/12
 * Time: 下午1:17
 */

namespace api\controllers;


use api\common\base\Controller;
use business\project\ProjectInterface;
use business\test\TestInterface;
use common\helpers\BaseHelper;

class TestController extends Controller
{

    private $_test;
    private $_project;

    public function __construct($id, \yii\base\Module $module, ProjectInterface $project, TestInterface $test, array $config = [])
    {
        $this->_project = $project;
        $this->_test = $test;
        parent::__construct($id, $module, $config);
    }

    protected function getProject()
    {
        $pid = \Yii::$app->request->get('pid');
        $this->_project->getProjectById($pid);
    }

    public function actionIndex()
    {
        $this->getProject();
        $params = \Yii::$app->request->get();
        $pid = isset($params['pid']) ? $params['pid'] : -1;
        $data = $this->_test->getTestWorkflowList($pid, $params);
        return $this->getList($data, $params);
    }

    public function actionFormValidate()
    {
        $this->getProject();
        $id = \Yii::$app->request->get('id');
        $pid = \Yii::$app->request->get('pid');
        // 测试流程规则
        $flowValidate = $this->_test->getTestWorkflowFormValidate();
        $order = $this->_test->getTestWorkflowOrder($pid);
        $flowValidate['model']['order'] = $order;
        // 测试项
        $itemNum = 0;
        $itemValidate = $this->_test->getTestItemFormValidate();
        $itemValidate['model']['before_item'] = [];
        $itemValidate['model'] = [$itemValidate['model']];
        // 用例设置
        $setCaseNum = 0;
        $time = 0;
        $setCaseValidate = $this->_test->getTestSetCaseFormValidate();
        $setCaseValidate['model']['wait_time'] = $time;
        $setCaseValidate['model'] = [[$setCaseValidate['model']]];
        // 期望
        $acceptNum = 0;
        $acceptValidate = $this->_test->getTestAcceptFormValidate();
        $acceptValidate['model'] = [[$acceptValidate['model']]];
        $isCreateCase = false;
        $isRun = $this->_test->isRun($id);
        if (!empty($id)) {
            $workflow = $this->_test->getTestWorkflowById($id);
            if (!empty($workflow)) {
                $flowValidate['model'] = $workflow;
            }
            $items = $this->_test->getTestItemByWorkflowId($id, $pid);
            if (count($items) > 0) {
                $itemNum = 1;
                $isCreateCase = true;
                $itemValidate['model'] = $items;
                $setCaseModel = $setCaseValidate['model'];
                $acceptModel = $acceptValidate['model'];
                $setCaseValidate['model'] = [];
                $acceptValidate['model'] = [];
                foreach ($items as $item) {
                    $tid = isset($item['id']) ? $item['id'] : '';
                    $setCase = $item->setCases;
                    if (count($setCase) > 0) {
                        $setCaseNum = 1;
                        $setCaseValidate['model'][$tid] = $setCase;
                    }
                    $accept = $item->accepts;
                    if (count($accept) > 0) {
                        $acceptNum = 1;
                        $acceptValidate['model'][$tid] = $accept;
                    }
                }
                if (empty($setCaseValidate['model'])) {
                    $setCaseValidate['model'] = $setCaseModel;
                }
                if (empty($acceptValidate['model'])) {
                    $acceptValidate['model'] = $acceptModel;
                }
            }

        }
        return [
            'flow'         => $flowValidate,
            'item'         => $itemValidate,
            'setCase'      => $setCaseValidate,
            'accept'       => $acceptValidate,
            'itemNum'      => $itemNum,
            'setCaseNum'   => $setCaseNum,
            'acceptNum'    => $acceptNum,
            'itemTypes'    => BaseHelper::getTestItemType(),
            'elementTypes' => BaseHelper::getTestCaseFindElementType(),
            'eventTypes'   => BaseHelper::getTestCaseEventType(),
            'acceptTypes'  => BaseHelper::getTestAcceptType(),
            'waitTime'     => $time,
            'isCreateCase' => !$isCreateCase,
            'isRun'        => $isRun,
        ];
    }

    public function actionTestItemName()
    {
        $this->getProject();
        $pid = \Yii::$app->request->get('pid');
        $id = \Yii::$app->request->get('id');
        $data = $this->_test->getTestItemByProjectId($pid, $id);
        return BaseHelper::changeJson($data);
    }

    public function actionUpdate()
    {
        $params = \Yii::$app->request->post();
        $data = $this->validateRequestParams($params, [
            'flow',
            'item',
            'setCase',
            'accept',
        ], []);
        $workflow = $this->_test->update($data);
        $id = isset($workflow['id']) ? $workflow['id'] : 0;
        return ['id' => $id];
    }

    public function actionGenerateCase()
    {
        $id = \Yii::$app->request->get('id');
        $this->getProject();
        $this->_test->generateCase($id);
        return [];
    }

    public function actionRun()
    {
        $id = \Yii::$app->request->get('id');
        $status = $this->_test->changeWorkFlowIsExe($id);
        return ['status' => $status->is_exe];
    }

    public function actionDeleteWorkflow()
    {
        $id = \Yii::$app->request->get('id');
        $this->_test->deleteTestWorkflowById($id);
        return [];
    }

}