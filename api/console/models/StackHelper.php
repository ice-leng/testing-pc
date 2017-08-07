<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/8/2
 * Time: 上午11:35
 */

namespace console\models;

/**
 * 栈
 *
 * Class stackHelper
 * @package console\models
 * @author  lengbin(lengbin0@gmail.com)
 */
class StackHelper
{

    protected $data;
    protected $index;

    public function __construct()
    {
        $this->data = [];
        $this->index = 0;
    }


    public function push($data)
    {
        $this->index++;
        $this->data[$this->index] = $data;
    }

    protected function isEmpty()
    {
        return $this->index === 0 || $this->data === [];
    }

    public function pull()
    {
        $data = [];
        if (!$this->isEmpty()){
            $data = $this->data[$this->index];
            unset($this->data[$this->index]);
            $this->index--;
        }
        return $data;
    }

}