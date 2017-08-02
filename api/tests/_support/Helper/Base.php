<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/7/23
 * Time: 下午1:50
 */

namespace Helper;

use lengbin\helper\directory\DirHelper;

require(dirname(dirname(dirname(__DIR__))) . '/vendor/yiisoft/yii2/Yii.php');
require(dirname(dirname(dirname(__DIR__))) . '/common/config/bootstrap.php');
require __DIR__ . '/Extension/Recorders.php';
require __DIR__ . '/BaseHelperCase.php';

class Base extends \Codeception\Module
{

    public $tag;

    public function setTagDir($tag)
    {
        $this->tag = $tag;
    }

    protected function pathExists($dir)
    {
        if (!is_dir($dir)) {
            DirHelper::pathExists($dir);
        }
    }

    protected function mv($src, $dis)
    {
        @copy($src, $dis);
        @unlink($src);
    }

    protected function mvLog()
    {
        $logDir = codecept_output_dir() . '/log';
        $this->pathExists($logDir);
        $this->mv(codecept_output_dir() . '/run.log', $logDir . '/run.log');
    }

    protected function mvCase()
    {
        $caseDir = codecept_output_dir() . '/' . $this->tag;
        $this->pathExists($caseDir);
        DirHelper::copyDir(codecept_output_dir(), $caseDir, [
            'record',
            'log',
            $this->tag,
        ], [], true);
    }

    public function _afterSuite()
    {
        \Helper\BaseHelperCase::getInstance(codecept_output_dir())->batchAddLog();
        parent::_afterSuite();
        $this->mvLog();
        $this->mvCase();
    }

}