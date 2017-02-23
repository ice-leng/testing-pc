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
use common\helpers\ElemeVueJsFormValidate;
use yii\base\Component;
use yii\base\Event;
use yii\web\BadRequestHttpException;

class BaseService extends Component
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
        $data = new ElemeVueJsFormValidate( $activeRecord, $params);
        return $data->createValidate();
    }

    /**
     *
     * 设置 事件绑定
     *
     * @param string $event 事件名称/命名空间
     */
    public function setEvents($event){
        if( empty($event) ) return;
        $status = false;
        // 检测 当前事件是否是 EventInterface 接口实现的
        $interfaces = class_implements($event);
        foreach ( $interfaces as $interface ){
            if( $interface == EventInterface::class  ) {
                $status = true;
                break;
            }
        }
        if( $status == false ) return;
        // 绑定事件
        $binds = call_user_func([ $event, 'triggers' ]);
        foreach ( $binds as $bind ){
            foreach ( $bind as $name => $fn ){
                ServerEvent::on($this->className(), $name, [\Yii::createObject($event), $fn]);
            }
        }
    }

    /**
     * 触发
     * @param string        $name   触发名称
     * @param Event | array $params 事件  /  参数
     *
     * @return Event
     */
    public function triggerService($name, $params)
    {
        if( !$params instanceof ServerEvent){
            $event = new ServerEvent();
            $event->setParams($params);
        }else{
            $event = $params;
        }
        $this->trigger($name, $event);
        return $event;
    }

}