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
     * 获得项目列表
     *
     * @return array []
     */
    public function getProjectList()
    {
        return $this->_project->getProjectList();
    }
}