<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/2/6
 * Time: 下午9:03
 */

namespace business\project\impl;


use business\common\BaseService;
use business\project\dao\Project;
use business\project\ProjectInterface;
use common\helpers\BaseHelper;

class ProjectImpl extends BaseService implements ProjectInterface
{

    private $_project;

    public function __construct(array $config = [])
    {
        $this->_project = new Project();
        parent::__construct($config);
    }

    /**
     * 获得浏览器名称
     *
     * @param  $type
     *
     * @return string
     */
    private function getBrowserName($type)
    {
        $browser = BaseHelper::getBrowserType(false);
        return (isset($browser[$type]) && !empty($browser[$type])) ? $browser[$type] : $type;
    }

    /**
     * 获得项目列表
     *
     * @return \array[]
     */
    public function getProjectList()
    {
        $projects = $this->_project->getProjectList();
        foreach ($projects['models'] as $key => $project) {
            $projects['models'][$key]['browser'] = $this->getBrowserName($project['browser']);
        }
        return $projects;
    }

    public function getFormValidate()
    {
        return $this->createFromValidate($this->_project);
    }

    /**
     * 更新 / 添加 项目
     *
     * @param array $params [id => '', name => '', url => '', browser => '']
     *
     * @return object
     * @author lengbin(lengbin0@gmail.com)
     */
    public function updateProject(array $params)
    {
        return $this->_project->updateProject($params);
    }
}