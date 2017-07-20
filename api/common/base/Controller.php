<?php

namespace common\base;

use yii\web\Response;

/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/2/2
 * Time: 下午1:40
 */
class Controller extends \yii\rest\Controller
{

    public function __construct($id, $module, array $config = [])
    {
        parent::__construct($id, $module, $config);
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats'] = ['application/json' => Response::FORMAT_JSON];
        return $behaviors;
    }

    // pages 处理
    protected function getList(array $result, array $params = [])
    {
        $page = $result['pages'];
        $offset = isset($_GET['page']) ? $_GET['page'] : '1';
        $totalPage = ceil($page->totalCount / $page->pageSize);
        $list = ($totalPage >= $offset) ? $result['models'] : [];
        return array_merge($params, [
            'list'        => $list,
            'currentPage' => $offset,
            'pageSize'    => $page->pageSize,
            'totalPage'   => $totalPage,
            'totalCount'  => $page->totalCount,
        ]);
    }

    /**
     * 验证请求参数字段
     * 支持别名
     *
     * @param array        $requests      请求参数  $_GET / $_POST
     * @param array        $validateField 验证字段，支持别名  ['别名' => 字段， 0 => 字段]
     * @param string/array $default       字段默认值 支持自定义 [字段 => 值]
     *
     * @return array
     * @author lengbin(lengbin0@gmail.com)
     */
    public function validateRequestParams($requests, $validateField, $default = '')
    {
        $data = [];
        foreach ($validateField as $key => $field) {
            $param = (isset($requests[$field]) && !empty($requests[$field])) ? $requests[$field] : null;
            if (!empty($default) && $param === null) {
                if (is_array($default)) {
                    $param = (isset($default[$field]) && !empty($default[$field])) ? $default[$field] : null;
                } else {
                    $param = $default;
                }
            }
            if($default === [] && $param === null){
                $param = [];
            }
            if (is_int($key)) {
                $data[$field] = $param;
            } else {
                $data[$key] = $param;
            }
        }
        return $data;
    }

}