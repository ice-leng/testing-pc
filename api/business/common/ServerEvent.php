<?php

/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/2/8
 * Time: 下午5:05
 */

namespace business\common;

class ServerEvent extends \yii\base\Event
{

    public $params = [];

    /**
     * 设置参数
     * @param array $params
     */
    public function setParams( array $params )
    {
        $this->params = $params;
    }

    /**
     * 获得所有参数
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * 获得参数
     * @param string $key
     *
     * @return string
     */
    public function getParam( $key )
    {
        return isset( $this->params[$key] ) ? $this->params[$key] : '';
    }

}