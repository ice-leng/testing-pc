<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/2/8
 * Time: 下午2:20
 */

namespace business\demo\event;


use business\common\EventInterface;
use business\demo\DemoInterface;

class DemoEvent implements EventInterface
{

    /**
     * 绑定接口
     * @return string 接口 类名/命名空间
     */
    public static function bindInterface()
    {
        return DemoInterface::class;
    }

    /**
     * 事件绑定
     * @return array [
     *                  [ 事件名称 => 实现方法名称 ],
     *                  [ 事件名称 => 实现方法名称2 ],
     *                  [ 事件名称2 => 实现方法名称2 ],
     *              ]
     */
    public static function triggers()
    {
        return [
            [DemoInterface::EVENT_BEFORE_LIST => 'demo'],
            [DemoInterface::EVENT_BEFORE_LIST => 'demo2'],
        ];
    }

    public function demo($event)
    {
        $params = $event->getParams();
        echo '方法一：' . $params[0] . '/';
    }

    public function demo2($event)
    {
        $params = $event->getParams();
        echo '方法二：' . $params[1] . '/';
    }

}