<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/2/2
 * Time: 下午4:58
 */

namespace common\helpers;


use yii\helpers\Json;
use yii\web\BadRequestHttpException;

class BaseHelper
{
    /**
     * 无效参数异常
     *
     * @param int    $code
     * @param string $message
     *
     * @throws BadRequestHttpException
     */
    public static function invalidParamException($code, $message)
    {
        if (is_array($message)) {
            $message = Json::encode($message);
        }
        throw new BadRequestHttpException($message, $code);
    }

    /**
     * 无效表单异常
     *
     * @param int    $code
     * @param string $message
     *
     * @throws BadRequestHttpException
     */
    public static function invalidFormException($code, $message)
    {
        if (is_array($message)) {
            $message = Json::encode($message);
        }
        throw new BadRequestHttpException($message, $code);
    }

    /**
     * 改变json
     *
     * @param $params
     * @param $isJson
     *
     * @return array
     * @author lengbin(lengbin0@gmail.com)
     */
    public static function changeJson($params, $isJson=true)
    {
        $data = [];
        if ($isJson) {
            foreach ($params as $id => $text) {
                $data[] = [
                    'id'   => $id,
                    'text' => $text,
                ];
            }
        } else {
            $data = $params;
        }
        return $data;
    }

    /**
     * 获得 性别 类型
     *
     * @param bool $isJson
     *
     * @return array
     * @author lengbin(lengbin0@gmail.com)
     */
    public static function getBrowserType($isJson = true)
    {
        $params = [
            ConstantHelper::BROWSER_TYPE_CHROME  => 'google浏览器',
            ConstantHelper::BROWSER_TYPE_FIREFOX => '火狐浏览器',
            ConstantHelper::BROWSER_TYPE_IE      => 'IE浏览器',
        ];
        return self::changeJson($params, $isJson);
    }

    /**
     * 获得 测试项类型
     *
     * @param bool $isJson
     *
     * @return array
     * @author lengbin(lengbin0@gmail.com)
     */
    public static function getTestItemType($isJson = true)
    {
        $params = [
            ConstantHelper::TEST_ITEM_TYPE_HREF => '访问',
            ConstantHelper::TEST_ITEM_TYPE_PAGE => '当前页',
        ];

        return self::changeJson($params, $isJson);
    }

    /**
     * 获得 事件类型
     *
     * @param bool $isJson
     *
     * @return array
     * @author lengbin(lengbin0@gmail.com)
     */
    public static function getTestCaseEventType($isJson = true)
    {
        $params = [
            ConstantHelper::TEST_CASE_EVENT_TYPE_INPUT    => '文本事件',
            ConstantHelper::TEST_CASE_EVENT_TYPE_CLIENT   => '点击事件',
            ConstantHelper::TEST_CASE_EVENT_TYPE_SELECT   => '选择/单选事件',
            ConstantHelper::TEST_CASE_EVENT_TYPE_CHECKBOX => '复选事件',
            ConstantHelper::TEST_CASE_EVENT_TYPE_FILE     => '上传事件',
            ConstantHelper::TEST_CASE_EVENT_TYPE_WAIT     => '等待事件',
        ];
        return self::changeJson($params, $isJson);
    }

    /**
     * 获得 查找类型
     *
     * @param bool $isJson
     *
     * @return array
     * @author lengbin(lengbin0@gmail.com)
     */
    public static function getTestCaseFindElementType($isJson = true)
    {
        $params = [
            ConstantHelper::TEST_CASE_FIND_ELEMENT_TYPE_ID    => 'id',
            ConstantHelper::TEST_CASE_FIND_ELEMENT_TYPE_XPATH => 'xpath',
            ConstantHelper::TEST_CASE_FIND_ELEMENT_TYPE_CLASS => 'class',
            ConstantHelper::TEST_CASE_FIND_ELEMENT_TYPE_CSS   => 'css',
            ConstantHelper::TEST_CASE_FIND_ELEMENT_TYPE_NAME  => 'name',
            ConstantHelper::TEST_CASE_FIND_ELEMENT_TYPE_LINK  => 'link',
        ];
        return self::changeJson($params, $isJson);
    }

    /**
     * 获得 验收类型
     *
     * @param bool $isJson
     *
     * @return array
     * @author lengbin(lengbin0@gmail.com)
     */
    public static function getTestAcceptType($isJson = true)
    {
        $params = [
            ConstantHelper::TEST_ACCEPT_TYPE_STRING_SEE           => '当前页面包含指定的文本',
            ConstantHelper::TEST_ACCEPT_TYPE_STRING_NOT_SEE       => '当前页面包不含指定的文本',
            ConstantHelper::TEST_ACCEPT_TYPE_CHECK_CHECKED        => '当前页面单选选中',
            ConstantHelper::TEST_ACCEPT_TYPE_CHECK_NOT_CHECKED    => '当前页面单选不选中',
            ConstantHelper::TEST_ACCEPT_TYPE_CHECKBOX_CHECKED     => '当前页面复选框选中',
            ConstantHelper::TEST_ACCEPT_TYPE_CHECKBOX_NOT_CHECKED => '当前页面复选不框选中',
            ConstantHelper::TEST_ACCEPT_TYPE_SELECT_SELECTED      => '当前页面下拉框选中',
            ConstantHelper::TEST_ACCEPT_TYPE_SELECT_NOT_SELECTED  => '当前页面下拉不框选中',
            ConstantHelper::TEST_ACCEPT_TYPE_URL_EQUAL            => '当前URI等于',
            ConstantHelper::TEST_ACCEPT_TYPE_URL_NOT_EQUAL        => '当前URI不等于',
            ConstantHelper::TEST_ACCEPT_TYPE_URL_MATCH            => '当前URI匹配',
            ConstantHelper::TEST_ACCEPT_TYPE_URL_NOT_MATCH        => '当前URI不匹配',
            ConstantHelper::TEST_ACCEPT_TYPE_CURRENT_URL_IN       => '当前的URI包含给定的字符串',
            ConstantHelper::TEST_ACCEPT_TYPE_CURRENT_URL_NOT_IN   => '当前的URI不包含给定的字符串',
            ConstantHelper::TEST_ACCEPT_TYPE_ELEMENT_SEE          => '当前页面包含指定的元素',
            ConstantHelper::TEST_ACCEPT_TYPE_ELEMENT_NOT_SEE      => '当前页面不包含指定的元素',
            ConstantHelper::TEST_ACCEPT_TYPE_SOURCE_IN            => '当前页面包含指定的源码',
            ConstantHelper::TEST_ACCEPT_TYPE_SOURCE_NOT_IN        => '当前页面不包含指定的源码',
            ConstantHelper::TEST_ACCEPT_TYPE_LINK_SEE             => '当前页面包含指定的连接',
            ConstantHelper::TEST_ACCEPT_TYPE_LINK_NOT_SEE         => '当前页面不包含指定的连接',
        ];
        return self::changeJson($params, $isJson);
    }

}