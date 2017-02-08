<?php

/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/2/6
 * Time: 下午10:06
 */

/**
 * 初始化 所有关于 business 服务
 * Class Init
 */
class Init
{


    /**
     * 文件读取
     *
     * @param array $dirName 目标目录
     *
     * @return array [ xxxx=>xxx ]
     */
    protected static function getFileNames($dirName)
    {
        $rootDir = Yii::getAlias('@business');
        $readDir = new \common\helpers\ReadDirHelper($rootDir);
        $readDir->setIsNamespace(true);
        $readDir->setTargetDir($dirName);
        $readDir->setFilterDirs(['common']);
        return $readDir->getFileNames();
    }

    /**
     *
     * 文件缓存 服务
     *
     * @return object
     */
    private static function _cacheService()
    {
        return \Yii::$container->get('yii\caching\FileCache', [], ['cachePath' => '@common/cache']);
    }

    /**
     * di
     */
    private static function _di()
    {
        // 先从 di  读取， 如果没有 读取缓存， 还是没有，读取文件
        $di = [];
        if( is_file('map/di.php') ) $di = require 'map/di.php';
        if (empty($di)) {
            $diKey = \common\helpers\ConstantHelper::COMMON_CACHE_DI;
            $di = self::_cacheService()->get($diKey);
            if (empty($di)) {
                $di = self::getFileNames(['impl']);
                self::_cacheService()->set($diKey, $di);
            }
        }
        return $di;
    }

    /**
     * event
     */
    private static function _event()
    {
        // 先从 event  读取， 如果没有 读取缓存， 还是没有，读取文件
        $event = [];
        if( is_file('map/event.php') ) $event = require 'map/event.php';
        if (empty($event)) {
            $eventKey = \common\helpers\ConstantHelper::COMMON_CACHE_EVENT;
            $event = self::_cacheService()->get($eventKey);
            if (empty($event)) {
                $event = self::getFileNames(['event']);
                self::_cacheService()->set($eventKey, $event);
            }
        }
        return $event;
    }


    /**
     *  run
     */
    public static function run()
    {
        // 事件 服务
        $diEvent = [];
        $event = self::_event();
        foreach ($event as $e) {
            $k = call_user_func([$e, 'bindInterface']);
            $diEvent[$k] = $e;
        }
        // di 服务
        $di = self::_di();
        foreach ($di as $d) {
            $data = ['class' => $d];
            \Yii::$container->set($d, $data);
            $interfaces = class_implements($d);
            foreach ($interfaces as $interface) {
                if (isset($diEvent[$interface]) && !empty($diEvent[$interface])) {
                    $data['events'] = $diEvent[$interface];
                }
                \Yii::$container->set($interface, $data);
            }
        }
    }

}

Init::run();