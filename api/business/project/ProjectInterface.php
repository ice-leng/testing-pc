<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/2/6
 * Time: 下午9:00
 */

namespace business\project;


interface ProjectInterface
{

    /**
     * 获得项目列表
     *
     * @return array []
     */
    public function getProjectList();

}