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
     * form validate
     * @return mixed
     */
    public function getFormValidate();

    /**
     * 获得项目列表
     *
     * @return array []
     */
    public function getProjectList();

    /**
     * 更新 / 添加 项目
     * @param array $params [id => '', name => '', url => '', browser => '']
     *
     * @return object
     * @author lengbin(lengbin0@gmail.com)
     */
    public function updateProject(array $params);

}