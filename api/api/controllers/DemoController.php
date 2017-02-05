<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/2/2
 * Time: 下午1:39
 */

namespace api\controllers;

use api\common\base\Controller;
use yii\web\NotFoundHttpException;

class DemoController extends Controller
{
    public function actionIndex()
    {
        return ['msg'=>'hello world!'];
    }
}