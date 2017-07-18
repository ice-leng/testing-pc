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
        $setCaseValidate = $this->_test->getTestSetCaseFormValidate();
        $setCaseValidate['model']['wait_time'] = 5;
        $setCaseValidate['model'] = [$setCaseValidate['model']];
        // 期望
        $acceptNum = 0;
        $acceptValidate = $this->_test->getTestAcceptFormValidate();
        $acceptValidate['model'] = [$acceptValidate['model']];
        if (!empty($id)) {
            $workflow = $this->_test->getTestWorkflowById($id);
            $flowValidate['model'] = $workflow;
        }
        return [
            'flow'      => $flowValidate,
            'item'      => $itemValidate,
            'case'      => $setCaseValidate,
            'accept'    => $acceptValidate,
            'itemNum'   => $itemNum,
            'caseNum'   => $setCaseNum,
            'acceptNum' => $acceptNum,
            'itemTypes' => BaseHelper::getTestItemType()
        ];
    }

    public function actionTestWorkflowName()
    {
        return [
            ['id' => 1, 'text' => '呵呵'],
            ['id' => 2, 'text' => '呵呵22'],
            ['id' => 3, 'text' => '呵呵333'],
        ];
    }

}