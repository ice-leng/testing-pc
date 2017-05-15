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
        $id = \Yii::$app->request->get('id');
        $validate = $this->_project->getFormValidate();
        if(!empty($id)){
            $project = $this->_project->getProjectById($id);
            $validate['model'] = $project;
        }
        return [
            'validate'    => $validate,
            'browserType' => ApiHelper::getBrowserType(),
        ];
    }

    public function actionUpdate()
    {
        $params = \Yii::$app->request->post();
        $data = [
            'id'      => isset($params['id']) ? $params['id'] : '',
            'name'    => isset($params['name']) ? $params['name'] : '',
            'url'     => isset($params['url']) ? $params['url'] : '',
            'browser' => isset($params['browser']) ? $params['browser'] : '',
        ];
        $this->_project->updateProject($data);
        return [];
    }

    public function actionDelete()
    {
        $id = \Yii::$app->request->get('id');
        $this->_project->deleteProjectById($id);
        return [];
    }

}