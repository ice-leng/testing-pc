<?php

namespace api\common\base;

use api\common\helpers\ApiHelper;
use api\common\helpers\CodeHelper;
use yii\web\BadRequestHttpException;

/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/2/2
 * Time: 下午1:41
 */
class Controller extends \common\base\Controller
{

    /**
     * 无效参数异常
     * @param int    $code
     * @param string $message
     *
     * @throws BadRequestHttpException
     */
    public function invalidParamException($code, $message = '')
    {
        if( $message == '' ) $message = CodeHelper::getCodeText($code);
        ApiHelper::invalidParamException($code, $message);
    }

    /**
     * 无效表单异常
     *
     * @param int    $code
     * @param string $message
     *
     * @throws BadRequestHttpException
     */
    public function invalidFormException($code, $message = '')
    {
        if( $message == '' ) $message = CodeHelper::getCodeText($code);
        ApiHelper::invalidFormException($code, $message);
    }

}