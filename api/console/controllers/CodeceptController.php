<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/7/21
 * Time: 下午5:22
 */

namespace console\controllers;

class CodeceptController extends \yii\console\Controller
{


    protected function cmd($str='')
    {
        $com = ' --steps --html --tap --ext DotReporter';
        $codecept = \Yii::getAlias('@vendor') . '/bin/codecept run ';
        $data = shell_exec($codecept . $str . $com);
        echo $data;
    }

    public function actionWeb()
    {
        $this->cmd('acceptance');
    }

    public function actionApi()
    {
        $this->cmd('api');
    }

    public function actionFailed()
    {
        $codecept = \Yii::getAlias('@vendor') . '/bin/codecept run -g failed ';
        $data = shell_exec($codecept );
        echo $data;
    }

}