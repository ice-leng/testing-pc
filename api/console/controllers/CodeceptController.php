<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/7/21
 * Time: 下午5:22
 */

namespace console\controllers;

use business\project\ProjectInterface;
use business\test\TestInterface;
use console\models\CreatePhpFile;
use lengbin\helper\directory\DirHelper;
use yii\base\Module;

class CodeceptController extends \yii\console\Controller
{

    private $_test;
    private $_project;

    public function __construct($id, Module $module, array $config = [], TestInterface $test, ProjectInterface $project)
    {
        $this->_test = $test;
        $this->_project = $project;
        parent::__construct($id, $module, $config);
    }

    protected function cmd($str = '', $tag = '')
    {
        $version = date('YmdHis');
        $output = \Yii::getAlias('@api') . '/web/tests/'. $version . '/' . $tag;
        if (!is_dir($output)) {
            DirHelper::pathExists($output);
        }
        $com = ' --steps --html index.html --tap run.log --ext DotReporter -o "paths: output: api/web/tests/' . $version . '/' . $tag . '"';
        $codecept = \Yii::getAlias('@vendor') . '/bin/codecept run ';
        $data = shell_exec($codecept . $str . $com);
        echo $data;
    }

    /**
     * generate script
     *
     * @author lengbin(lengbin0@gmail.com)
     */
    public function actionGenerateScript()
    {
        $dir = \Yii::getAlias('@tests');
        $workflow = $this->_test->getExeTestWorkflowList();
        if (empty($workflow)) {
            echo "没有需要执行的流程，请查看系统 \n\s";
            return;
        }
        $pids = [];
        foreach ($workflow as $f) {
            $pid = isset($f['project_id']) ? $f['project_id'] : '';
            $pids[] = $pid;
        }
        $php = new CreatePhpFile();
        $items = $this->_test->getTestItemByProjectId($pids, 0, true);
        $projects = $this->_project->getProjectByIds($pids);
        $php->setItems($items);
        $php->setProjects($projects);
        $itemIds = array_keys($items);
        $rightCase = $this->_test->getRightTestCaseByItemId($itemIds);
        $php->setRightCase($rightCase);
        $accept = $this->_test->getTestAcceptByItemId($itemIds);
        $php->setTestAccepts($accept);
        foreach ($workflow as $flow) {
            $php->body($flow);
            $cases = $flow->cases;
            foreach ($cases as $case) {
                $php->setCase($case);
            }
            $php->generateFile($dir);
        }
        echo "文件生成成功 \n\s";
    }

    /**
     * web test
     * @author lengbin(lengbin0@gmail.com)
     */
    public function actionWeb()
    {
        $this->cmd('acceptance', 'html');
    }

    /**
     * api test
     * @author lengbin(lengbin0@gmail.com)
     */
    public function actionApi()
    {
        $this->cmd('api', 'api');
    }

    /**
     * test after failed group, run this , test failed case
     * @author lengbin(lengbin0@gmail.com)
     */
    public function actionFailed()
    {
        $codecept = \Yii::getAlias('@vendor') . '/bin/codecept run -g failed ';
        $data = shell_exec($codecept);
        echo $data;
    }

}