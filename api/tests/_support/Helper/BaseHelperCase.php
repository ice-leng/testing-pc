<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/7/27
 * Time: 下午5:37
 */

namespace Helper;


class BaseHelperCase
{
    public function _after()
    {
        var_dump('base - after');
    }
}