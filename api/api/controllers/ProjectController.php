<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/2/21
 * Time: 上午10:19
 */

namespace api\controllers;


use api\common\base\Controller;
use api\common\helpers\ApiHelper;
use business\project\ProjectInterface;

class ProjectController extends Controller
{
    private $_project;

    public function __construct($id, \yii\base\Module $module, ProjectInterface $project, array $config = [])
    {
        $this->_project = $project;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex()
    {
        $data = $this->_project->getProjectList();
        return $this->getList($data);
    }

    public function actionFormValidate()
    {
        return [
            'validate'    => $this->_project->getFormValidate(),
            'browserType' => ApiHelper::getBrowserType(),
        ];
    }

}