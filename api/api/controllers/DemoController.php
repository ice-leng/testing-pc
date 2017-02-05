<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/2/2
 * Time: 下午1:39
 */

namespace api\controllers;

use api\common\base\Controller;
use business\demo\DemoInterface;

class DemoController extends Controller
{

    private $_demo;

    public function __construct($id, \yii\base\Module $module, DemoInterface $demo, array $config = [])
    {
        $this->_demo = $demo;
        parent::__construct($id, $module, $config);
    }


    public function actionIndex()
    {
        return $this->_demo->getData();
    }
}