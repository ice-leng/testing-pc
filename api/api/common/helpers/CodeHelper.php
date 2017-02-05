<?php

namespace api\common\helpers;

/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/2/2
 * Time: 下午4:57
 */
class CodeHelper extends \common\helpers\CodeHelper
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
     *  1开头  为 项目
     *
     *
     *  以此为例,仅供参考,待补充
     */
    const PROJECT_ERROR = 20001;

    /**--------------code 常量-------------------**/

    public static function init()
    {
        $init = parent::init();
        $translates = [
            self::PROJECT_ERROR => 'xxx',

        ];
        return $init + $translates;
    }
}