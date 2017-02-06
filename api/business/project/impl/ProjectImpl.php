<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/2/6
 * Time: 下午9:03
 */

namespace business\project\impl;


use business\common\BaseService;
use business\project\ProjectInterface;

class ProjectImpl extends BaseService implements ProjectInterface
{

    /**
     * 获得项目列表
     *
     * @return array []
     */
    public function getProjectList()
    {
        return ['你好'];
    }
}