<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/2/5
 * Time: 下午8:14
 */

$impls = [
    'Demo.Demo' => \business\demo\impl\DemoImpl::class,
    'Project.Project' => \business\project\impl\ProjectImpl::class,
];


foreach( $impls as $name => $impl ){
    $interfaces = class_implements($impl);
    Yii::$container->set($name, $impl);
    foreach( $interfaces as $interface){
        Yii::$container->set($interface, ['class' => $impl]);
    }
}

