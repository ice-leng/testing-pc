<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/2/5
 * Time: 下午8:14
 */

$impls = [
    \business\demo\impl\DemoImpl::class,
    \business\project\impl\ProjectImpl::class,
];


foreach( $impls as $impl ){
    $interfaces = class_implements($impl);
    Yii::$container->set($impl, $impl);
    foreach( $interfaces as $interface){
        Yii::$container->set($interface, ['class' => $impl]);
    }
}

