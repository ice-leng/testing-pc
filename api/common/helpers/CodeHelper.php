<?php

namespace common\helpers;

/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/2/2
 * Time: 下午4:57
 */
class CodeHelper
{

    // code 字典
    public static $codes;

    /**
     * 错误信息
     *
     * @param string $code code
     *
     * @return string
     *
     * @auth ice.leng(lengbin@geridge.com)
     * @issue
     */
    public static function getCodeText($code)
    {
        if (is_null(self::$codes)) {
            self::$codes = self::init();
        }
        return self::$codes[$code];
    }

    /**--------------code 常量-------------------**/
    /*
     *  code  编码分类 code 长度为 6位
     *
     *  0开头  为 系统
     *  1开头  为 项目
     *
     *
     *  以此为例,仅供参考,待补充
     */
    /** 系统 保留 http code **/
    CONST SYS_SUCCESS = 0;
    CONST SYS_PARAMS_ERROR = 1;
    CONST SYS_FORM_ERROR = 2;
    CONST SYS_NOT_FOUND = 404;
    /** 系统 **/

    /**--------------code 常量-------------------**/


    /**
     * 字典
     * @return array
     *
     * @auth ice.leng(lengbin@geridge.com)
     * @issue
     */
    public static function init()
    {
        /*
         *  code  编码分类 code 长度为 6位
         *  0开头  为 系统
         *  1开头  为 项目
         *
         *
         *  以此为例,仅供参考,待补充
         */
        return [
            /** 系统 **/
            self::SYS_SUCCESS      => 'Success',
            self::SYS_PARAMS_ERROR => '请求参数错误',
            self::SYS_FORM_ERROR   => '请求表单参数错误',
            self::SYS_NOT_FOUND    => 'Not Found',
            /** 系统 **/
            /** 项目 **/


            /** 项目 **/
        ];
    }

}