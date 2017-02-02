<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/2/2
 * Time: 下午1:39
 */

namespace frontend\controllers;


use frontend\common\base\Controller;

class DemoController extends Controller
{
    public function actionIndex()
    {
        return ['name' => '12'];
    }

}