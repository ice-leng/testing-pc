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
     *  run
     */
    public static function run()
    {
        // di 服务
        self::di();
        // event 服务

        // 系统字典
        self::dist();
    }

    /**
     * di
     */
    public static function di()
    {
        // 先从 di  读取， 如果没有 读取缓存， 还是没有，读取文件
        $impls = require 'map/di.php';
        if( empty( $impls ) ){
            $diKey = \common\helpers\ConstantHelper::COMMON_CACHE_DI;
            $impls = self::_cacheService()->get($diKey);
            if( empty( $impls ) ) {
                $impls = self::getFileNames(['impl']);
                self::_cacheService()->set($diKey, $impls);
            }
        }
        foreach( $impls as $impl ){
            $interfaces = class_implements($impl);
            \Yii::$container->set($impl, $impl);
            foreach( $interfaces as $interface){
                \Yii::$container->set($interface, ['class' => $impl]);
            }
        }
    }

    /**
     *  字典
     */
    public static function dist()
    {

    }

}

Init::run();