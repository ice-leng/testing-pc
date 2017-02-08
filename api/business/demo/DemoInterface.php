<?php

/**
 * demo interface
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/2/5
 * Time: 下午6:28
 */

namespace business\demo;

interface DemoInterface
{

    CONST EVENT_BEFORE_LIST = 'before_list';

    /**
     * 获得demo列表
     *
     * @return array [ [
     *                  id   => '', // id
     *                  name => '', // name
     *               ] ]
     */
    public function getDemoList();

    /**
     * 获得 demo validate rules
     *
     * @return array [
     *                  'validates' => [], //每个字段的验证规则
     *                  'labels' => [] , // 每个字段的label
     *                  '_csrf' => [],   // yii2 csrf 请求值
     *              ]
     */
    public function getDemoValidate();

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
    public function updateDemo(array $params);
}