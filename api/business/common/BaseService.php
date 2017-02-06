<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/2/5
 * Time: 下午6:31
 */

namespace business\common;


use common\helpers\BaseHelper;
use common\helpers\CodeHelper;
use common\helpers\CreateFromValidate;
use yii\web\BadRequestHttpException;

class BaseService
{

    /**
     * 无效参数异常
     *
     * @param int    $code
     * @param string $message
     *
     * @throws BadRequestHttpException
     */
    public function invalidParamException($code, $message = '')
    {
        if ($message == '') {
            $message = CodeHelper::getCodeText($code);
        }
        BaseHelper::invalidParamException($code, $message);
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
        if ($message == '') {
            $message = CodeHelper::getCodeText($code);
        }
        BaseHelper::invalidFormException($code, $message);
    }

    /**
     * 创建表单验证规则
     *
     * @param ActiveRecord $activeRecord
     * @param array        $params
     * @param string       $scenario 场景
     *
     * @return mixed
     *
     * @auth ice.leng(lengbin@geridge.com)
     * @issue
     */
    public function createFromValidate(ActiveRecord $activeRecord, array $params = [], $scenario = '')
    {
        if( !empty($scenario) ){
            $activeRecord->scenario = $scenario;
        }
        $data = new CreateFromValidate( $activeRecord, $params);
        return $data->createValidate();
    }

}