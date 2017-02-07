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

    protected static function getFileNames($dirName)
    {
        $rootDir = Yii::getAlias('@business');
        $readDir = new \common\helpers\ReadDirHelper($rootDir);
        $readDir->setIsNamespace(true);
        $readDir->setTargetDir($dirName);
        $readDir->setFilterDirs(['common']);
        return $readDir->getFileNames();
    }

    public static function run()
    {
        // di 服务
        self::di();
        // event 服务

    }

    public static function di()
    {
        $impls = require 'map/di.php';
        if( empty( $impls ) ) $impls = self::getFileNames(['impl']);
        foreach( $impls as $name => $impl ){
            $interfaces = class_implements($impl);
            \Yii::$container->set($name, $impl);
            foreach( $interfaces as $interface){
                \Yii::$container->set($interface, ['class' => $impl]);
            }
        }
    }
}

Init::run();