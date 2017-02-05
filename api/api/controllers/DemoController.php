<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/2/2
 * Time: 下午1:39
 */

namespace api\controllers;

use api\common\base\Controller;
use api\common\helpers\CodeHelper;

class DemoController extends Controller
{
    public function actionIndex()
    {
        return ['hello world!'];
    }

    public function actionError()
    {
        return [
            'code'    => CodeHelper::SYS_NOT_FOUND,
            'message' => CodeHelper::getCodeText(CodeHelper::SYS_NOT_FOUND),
        ];
    }

}