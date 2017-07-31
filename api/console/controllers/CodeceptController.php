<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/7/21
 * Time: 下午5:22
 */

namespace console\controllers;

use lengbin\helper\directory\DirHelper;

class CodeceptController extends \yii\console\Controller
{


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
        echo '哈哈';
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