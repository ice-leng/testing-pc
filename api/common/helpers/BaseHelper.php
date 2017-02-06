<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/2/2
 * Time: 下午4:58
 */

namespace common\helpers;


use yii\helpers\Json;
use yii\web\BadRequestHttpException;

class BaseHelper
{
    /**
     * 无效参数异常
     * @param int    $code
     * @param string $message
     *
     * @throws BadRequestHttpException
     */
    public static function invalidParamException($code, $message)
    {
        if( is_array( $message ) ) $message = Json::encode($message);
        throw new BadRequestHttpException($message, $code);
    }

    /**
     * 无效表单异常
     *
     * @param int    $code
     * @param string $message
     *
     * @throws BadRequestHttpException
     */
    public static function invalidFormException($code, $message)
    {
        if( is_array( $message ) ) $message = Json::encode($message);
        throw new BadRequestHttpException($message, $code);
    }
}