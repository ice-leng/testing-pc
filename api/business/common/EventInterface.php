<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/2/8
 * Time: 下午2:21
 */

namespace business\common;

/**
 * 事件接口, 事件触发在 实现类。
 * Interface EventInterface
 * @package business\common
 */
interface EventInterface
{
    /**
     * 绑定接口
     * @return string 接口 类名/命名空间
     */
    public static function bindInterface();

    /**
     * 事件绑定
     * @return array [
     *                  [ 事件名称 => 实现方法名称 ],
     *                  [ 事件名称 => 实现方法名称2 ],
     *                  [ 事件名称2 => 实现方法名称2 ],
     *              ]
     */
    public static function triggers();

}