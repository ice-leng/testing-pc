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
                    if( is_array($data) || ( $response->format == 'json' && count( json_decode($data, true) ) == 1 ) ){
                        $code = \api\common\helpers\CodeHelper::SYS_SUCCESS;
                        // message 默认为 系统定义
                        // 当系统存在message 时， 如果数据传输过来是 json字符串，输出是转为json
                        $message = \api\common\helpers\CodeHelper::getCodeText($code);
                        if( isset($data['message']) && !empty( $data['message'] ) ){
                            $message = json_decode($data['message']) == null ? $data['message'] : json_decode($data['message']);
                        }
                        $response->data = [
                            'code' => isset($data['code']) ? $data['code'] : $code,
                            'message' => $message,
                        ];
                        if( $response->data['code'] == 0 ) $response->data['data'] = $data;
                    }
                    // http 请求 全部为 200 请求通过。
                    $response->statusCode = 200;
                    // 设置 跨域问题
                    $response->headers->add('Access-Control-Allow-Origin',Yii::$app->request->headers->get('Origin'));
                    $response->headers->set('Access-Control-Allow-Credentials','true');
                    $response->headers->set("Access-Control-Allow-Headers","Content-Type,X-Requested-With,Accept");
                    $response->headers->set("Access-Control-Allow-Methods","GET,POST");
                    $response->headers->set("Access-Control-Request-Methods","GET,POST");
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
