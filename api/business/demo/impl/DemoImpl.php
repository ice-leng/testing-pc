<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/2/5
 * Time: 下午6:30
 */

namespace business\demo\impl;


use business\common\BaseService;
use business\demo\DemoInterface;

class DemoImpl extends BaseService implements DemoInterface
{

    /**
     * 获得demo 数据
     *
     * @return array
     */
    public function getData()
    {
        return ['msg'=>'hello world!'];
    }
}