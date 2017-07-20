<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/7/12
 * Time: 下午1:17
 */

namespace api\controllers;


use api\common\base\Controller;
use business\test\TestInterface;
use common\helpers\BaseHelper;

class TestController extends Controller
{

    private $_test;

    public function __construct($id, \yii\base\Module $module, TestInterface $test, array $config = [])
    {
        $this->_test = $test;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex()
    {
        return [];
    }

    public function actionFormValidate()
    {
        $id = \Yii::$app->request->get('id');
        // 测试流程规则
        $flowValidate = $this->_test->getTestWorkflowFormValidate();
        $order = $this->_test->getTestWorkflowOrder();
        $flowValidate['model']['order'] = $order;
        // 测试项
        $itemNum = 0;
        $itemValidate = $this->_test->getTestItemFormValidate();
        $itemValidate['model'] = [$itemValidate['model']];
        // 用例设置
        $setCaseNum = 0;
        $time = 5;
        $setCaseValidate = $this->_test->getTestSetCaseFormValidate();
        $setCaseValidate['model']['wait_time'] = $time;
        $setCaseValidate['model'] = [[$setCaseValidate['model']]];
        // 期望
        $acceptNum = 0;
        $acceptValidate = $this->_test->getTestAcceptFormValidate();
        $acceptValidate['model'] = [[$acceptValidate['model']]];
        $isCreateCase = false;
        $isRun = false;
        if (!empty($id)) {
            $itemNum = 1;
            $workflow = $this->_test->getTestWorkflowById($id);
            $flowValidate['model'] = $workflow;
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
            'isRun'        => !$isRun,
        ];
    }

    public function actionTestWorkflowName()
    {
        $pid = \Yii::$app->request->get('pid');
        $data = $this->_test->getTestWorkflowByProjectId($pid);
        return BaseHelper::changeJson($data);
    }

    public function actionUpdate()
    {
        $params = \Yii::$app->request->post();
        $data = $this->validateRequestParams($params, [
            'flow',
            'item',
            'setCase',
            'accept'
        ], []);
        $workflow = $this->_test->update($data);


        return $params;
    }

}