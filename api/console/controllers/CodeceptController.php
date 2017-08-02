<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/7/21
 * Time: 下午5:22
 */

namespace console\controllers;

use business\test\TestInterface;
use console\models\CreatePhpFile;
use lengbin\helper\directory\DirHelper;
use yii\base\Module;

class CodeceptController extends \yii\console\Controller
{

    private $_test;

    public function __construct($id, Module $module, array $config = [], TestInterface $test)
    {
        $this->_test = $test;
        parent::__construct($id, $module, $config);
    }

    protected function cmd($str='')
    {
        $output =  \Yii::getAlias('@api') . '/web/tests';
        if(!is_dir($output)){
            DirHelper::pathExists($output);
        }
        $com = ' --steps --html index.html --tap run.log --ext DotReporter -o "paths: output: api/web/tests/'.date('YmdHis').'"';
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
        $types = [
            1 => 'acceptance',
            2 => 'api',
        ];
        $dir = \Yii::getAlias('@tests');
        $workflow = $this->_test->getExeTestWorkflowList();
        foreach ($workflow as $flow){
            $php = new CreatePhpFile();
            $php->head($flow);
            $php->setType($types[1]);
            if(!empty($flow->before_flow)){
                $ids = explode(',', $flow->before_flow);
                $beforeCases = $this->_test->getTestCaseByWorkflowId($ids, true);
                $php->setBefore($beforeCases);
            }
            $cases = $flow->cases;
            foreach ($cases as $case){
                $php->setCase($case);
            }
            $php->generateFile($dir);
        }
    }

    /**
     * web test
     * @author lengbin(lengbin0@gmail.com)
     */
    public function actionWeb()
    {
        $this->cmd('acceptance');
    }

    /**
     * api test
     * @author lengbin(lengbin0@gmail.com)
     */
    public function actionApi()
    {
        $this->cmd('api');
    }

    /**
     * test after failed group, run this , test failed case
     * @author lengbin(lengbin0@gmail.com)
     */
    public function actionFailed()
    {
        $codecept = \Yii::getAlias('@vendor') . '/bin/codecept run -g failed ';
        $data = shell_exec($codecept );
        echo $data;
    }

}