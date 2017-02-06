<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'api\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-pc',
            'csrfCookie' => [
                'httpOnly' => true,
                'path' => '/api',
            ],
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'response' => [
            'class' => 'yii\web\Response',
            'on beforeSend' => function ($event) {
                $response = $event->sender;
                if ($response->data !== null) {
                    $data = $response->data;
                    //当抛出异常时，返回数据为string, 数据需要过滤掉
                    if( is_array($data) || $response->format == 'json' ){
                        $code = \api\common\helpers\CodeHelper::SYS_SUCCESS;
                        $response->data = [
                            'code' => isset($data['code']) ? $data['code'] : $code,
                            'message' => isset($data['message']) ? $data['message'] : \api\common\helpers\CodeHelper::getCodeText($code),
                        ];
                        if( $response->data['code'] == 0 ) $response->data['data'] = $data;
                    }
                    // http 请求 全部为 200 请求通过。
                    $response->statusCode = 200;
                }
            }
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => '_tester-api',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            //            'errorAction' => 'demo/error',
            'class'=>'common\base\ErrorHandler',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
    ],
    'params' => $params,
];
