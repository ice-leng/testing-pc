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
    /**
     * 获得demo 数据
     *
     * @return array
     */
    public function getData();
}