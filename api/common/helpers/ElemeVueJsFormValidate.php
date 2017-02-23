<?php
/**
 * 饿了么 vue js 的 form validate 生成帮助类
 * User: lengbin
 * Date: 2017/2/23
 * Time: 上午10:57
 */

namespace common\helpers;


use yii\base\Model;

class ElemeVueJsFormValidate extends CreateFromValidate
{
    //regexp

    private $_notSupportValidate = [
        'trim'
    ];
    private $_supportValidate = [
        'required' => 'required',
        'string'   => 'string',
        'number'   => 'number',
        'email'    => 'email',
        'integer'  => 'integer',
        'url'      => 'url',
        'in'       => 'enum',
        'match'    => 'regexp',
    ];

    public function createValidate()
    {
        $rules = parent::createValidate();
        return $rules;
    }

}