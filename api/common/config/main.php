<?php

require(__DIR__ . '/../../business/common/Init.php');

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language'=>'zh-CN',
    'timeZone'=>'Asia/Shanghai',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
