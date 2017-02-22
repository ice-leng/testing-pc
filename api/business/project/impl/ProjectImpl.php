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
        $browser = [
            1 => '谷歌浏览器',
            2 => '火狐浏览器',
        ];
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
}