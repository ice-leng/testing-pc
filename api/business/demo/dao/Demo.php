<?php

namespace business\demo\dao;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "demo".
 *
 * @property integer $id
 * @property string  $name
 * @property integer $created_at
 * @property integer $updated_at
 */
class Demo extends \business\common\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'demo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['id', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 32,],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'name'       => 'name',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * 获得demo列表
     *
     * @return array [ [
     *                  id   => '', // id
     *                  name => '', // name
     *               ] ]
     */
    public function getDemoList()
    {
        $query = new Query();
        $query->select([
            'id',
            'name'
        ])->from($this->tableName());
        return $this->page($query);
    }

    /**
     * 通过 id 获得 demo 数据
     *
     * @param int $id
     *
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getDemoById($id)
    {
        return $this->find()->where(['id' => $id])->one();
    }

    /**
     * 添加 / 更新 demo
     *
     * @param array $params [
     *                          id => '',  // id
     *                          name => '', // name
     *                      ]
     *
     * @return object
     */
    public function updateDemo(array $params)
    {
        $mode = new Demo();
        $mode->setAttributes($params);
        if( !$mode->validate() ) $this->invalidFormException( $mode->getErrors() );
        if( $mode->id > 0 ){
            $demo = $this->getDemoById($mode->id);
            if( empty($demo) ) $this->invalidParamException('id不存在');
            $demo->setAttributes($mode->getAttributes());
        }else{
            $demo = $mode;
        }
        $demo->save();
        return $demo;
    }

}
