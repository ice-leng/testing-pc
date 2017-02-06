<?php

/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/2/6
 * Time: 下午3:17
 */

namespace business\common;

use common\helpers\BaseHelper;
use common\helpers\CodeHelper;
use yii\data\Pagination;
use yii\db\Query;
use yii\web\BadRequestHttpException;

class ActiveRecord extends \yii\db\ActiveRecord
{

    public function __construct(array $config = [])
    {
        $this->on(self::EVENT_BEFORE_INSERT, [$this, 'saveBeforeInsert']);
        $this->on(self::EVENT_BEFORE_UPDATE, [$this, 'saveBeforeUpdate']);
        parent::__construct($config);
    }

    protected function saveBeforeInsert($event)
    {
        $time = time();
        if( $this->hasAttribute('created_at') && empty( $this->created_at ) ) $this->created_at = $time;
        if( $this->hasAttribute('updated_at') && empty( $this->updated_at ) ) $this->updated_at = $time;
    }

    protected function saveBeforeUpdate($event)
    {
        $time = time();
        if( $this->hasAttribute('updated_at') ) $this->updated_at = $time;
    }


    /**
     * 无效参数异常
     *
     * @param int    $code
     * @param string $message
     *
     * @throws BadRequestHttpException
     */
    public function invalidParamException($message = '', $code = CodeHelper::SYS_PARAMS_ERROR)
    {
        if ($message == '') {
            $message = CodeHelper::getCodeText($code);
        }
        BaseHelper::invalidParamException($code, $message);
    }

    /**
     * 无效表单异常
     *
     * @param int    $code
     * @param string $message
     *
     * @throws BadRequestHttpException
     */
    public function invalidFormException($message = '', $code = CodeHelper::SYS_FORM_ERROR)
    {
        if ($message == '') {
            $message = CodeHelper::getCodeText($code);
        }
        BaseHelper::invalidFormException($code, $message);
    }


    /**
     * 分页
     * @param Query  $query
     * @param int $pageSize
     *
     * @return array
     *
     * @auth ice.leng(lengbin@geridge.com)
     * @issue
     */
    public function page(Query $query, $pageSize = '')
    {
        $size = !empty( $pageSize ) ? intval( $pageSize ) : 4;
        $count = $query->count();
        $pages = new Pagination( ['totalCount' => $count, 'pageSize' => $size] );
        $models = $query->offset( $pages->offset )->limit( $pages->limit )->all();
        return [
            'models' => $models,
            'pages'  => $pages,
        ];
    }

    /**
     * debug
     * @param Query $query
     */
    public function debugForQuery(Query $query)
    {
        echo $query->createCommand()->sql;
        var_dump($query->createCommand()->params);
        die;
    }

    /**
     * 重构 getAttributes 方法， 如果返回值是空， 则不返回
     * @param null  $names
     * @param array $except
     *
     * @return array
     */
    public function getAttributes($names = null, $except = [])
    {
        $values = parent::getAttributes($names, $except);
        foreach( $values as $name => $value ){
            if( empty( $value ) ) unset( $values[$name] );
        }
        return $values;
    }


}