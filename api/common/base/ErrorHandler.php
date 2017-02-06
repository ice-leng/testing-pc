<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/2/5
 * Time: 下午4:28
 */

namespace common\base;

use Yii;
use yii\helpers\Json;
use yii\web\Response;

/**
 * yii2 错误 异常抛出
 * Class ErrorHandler
 * @package common\base
 */
class ErrorHandler extends \yii\web\ErrorHandler
{
    /**
     * 重写 yii2 错误 异常抛出，
     * 在app/config/main.php 中修改（每个应用使用不一样，配置也不一样）
     *
     * 当 yii 抛出异常时，errorHandler 会接收异常数据，yii2 会生成 html 代码片段返回在页面上
     * 由于我使用的是api接口，所以将 返回改为 json 数据
     *
     * 返回配置参数
     * 'response' => [
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
     *
     * 错误配置
     'errorHandler' => [
        'class'=>'common\base\ErrorHandler',
     ],
     *
     *
     *
     *
     *
     * @param \Exception $exception
     */
    protected function renderException($exception)
    {
        if (Yii::$app->has('response')) {
            $response = Yii::$app->getResponse();
            $response->isSent = false;
            $response->stream = null;
            $response->data = null;
            $response->content = null;
        } else {
            $response = new Response();
        }

        $data = $this->convertExceptionToArray($exception);
        // 当 code 为 0 的时候 说明是 yii2 自带抛错
        if( $data['code'] == 0 ){
            $response->data = Json::encode([
                'code'    => $data['status'],
                'message' => $data['message'],
            ]);
        }else{
            $response->data = $data;
        }
        $response->send();
    }

}