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

    private $_notSupportValidate = [
        'trim',
    ];
    private $_supportValidate = [
        'required',
        'string',
        'number',
        'email',
        'integer',
        'url',
        'in',
        'match',
    ];

    private function _refactoring($rule)
    {
        $data = [];
        switch ($rule['type']) {
            case 'required':
                $data = [
                    'required' => true,
                    'message'  => $rule['message'],
                    'trigger'  => 'blur',
                ];
                break;
            case 'string':
                if (isset($rule['min'])) {
                    $data = [
                        'type'    => 'string',
                        'min'     => $rule['min'],
                        'message' => $rule['message'],
                        'trigger' => 'blur',
                    ];
                }
                if (isset($rule['max'])) {
                    $data = [
                        'type'    => 'string',
                        'max'     => $rule['max'],
                        'message' => $rule['message'],
                        'trigger' => 'blur',
                    ];
                }
                if (isset($rule['min']) && isset($rule['max'])) {
                    $data = [
                        'type'    => 'string',
                        'min'     => $rule['min'],
                        'max'     => $rule['max'],
                        'message' => $rule['message'],
                        'trigger' => 'blur',
                    ];
                }
                break;
            case 'number':
                $data = [
                    'type'    => 'number',
                    'message' => $rule['message'],
                    'trigger' => 'blur,change',
                ];
                break;
            case 'email':
                $data = [
                    'type'    => 'email',
                    'message' => $rule['message'],
                    'trigger' => 'blur,change',
                ];
                break;
            case 'in' :
                $data = [
                    'type'    => 'array',
                    'message' => $rule['message'],
                    'trigger' => 'change',
                ];
                break;
            case 'integer':
                $data = [
                    'type'    => 'integer',
                    'message' => $rule['message'],
                    'trigger' => 'blur,change',
                ];
                break;
            default:
                $data = [
                    'type'    => 'string',
                    'pattern' => $rule['rule'],
                    'message' => $rule['message'],
                    'trigger' => 'blur,change',
                ];
                break;
        }
        return $data;
    }

    public function createValidate()
    {
        $data = [];
        $rules = parent::createValidate();
        foreach ($rules['validates'] as $rule) {
            if (in_array($rule['type'], $this->_notSupportValidate)) {
                continue;
            }
            if (!in_array($rule['type'], $this->_supportValidate)) {
                continue;
            }
            foreach ($rule['field'] as $field) {
                if (isset($data[$field])) {
                    array_push($data[$field], $this->_refactoring($rule));
                } else {
                    $data[$field][] = $this->_refactoring($rule);
                }

            }
        }
        $rules['validates'] = $data;
        return $rules;
    }

}