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

}