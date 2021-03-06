<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/2/5
 * Time: 下午6:30
 */

namespace business\demo\impl;


use business\common\BaseService;
use business\demo\dao\Demo;
use business\demo\DemoInterface;

class DemoImpl extends BaseService implements DemoInterface
{

    private $_demo;

    public function __construct(array $config = [])
    {
        $this->_demo = new Demo();
        parent::__construct($config);
    }

    /**
     * 获得demo列表
     *
     * @return array [ [
     *                  id   => '', // id
     *                  name => '', // name
     *               ] ]
     */
    public function getDemoList()
    {

        $this->triggerService(self::EVENT_BEFORE_LIST, ['传入数据1','传入数据2']);
        echo '外面实现类数据：';
        return $this->_demo->getDemoList();
    }

    /**
     * 添加 / 更新 demo
     *
     * @param array $params [
     *                          id => '',  // id
     *                          name => '', // name
     *                      ]
     *
     * @return object
     */
    public function updateDemo(array $params)
    {
        return $this->_demo->updateDemo($params);
    }

    /**
     * 获得 demo validate rules
     *
     * @return array [
     *                  'validates' => [], //每个字段的验证规则
     *                  'labels' => [] , // 每个字段的label
     *                  '_csrf' => [],   // yii2 csrf 请求值
     *              ]
     */
    public function getDemoValidate()
    {
        return $this->createFromValidate($this->_demo);
    }




}