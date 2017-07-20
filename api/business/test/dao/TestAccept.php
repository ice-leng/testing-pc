<?php

namespace business\test\dao;

use Yii;

/**
 * This is the model class for table "test_accept".
 *
 * @property integer $id
 * @property integer $test_item_id
 * @property integer $element_type
 * @property string  $element
 * @property integer $accept_type
 * @property string  $accept_params
 * @property integer $is_delete
 * @property integer $created_at
 * @property integer $updated_at
 */
class TestAccept extends \business\common\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'test_accept';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['test_item_id', 'element', 'accept_params', 'accept_type'], 'required'],
            [['test_item_id', 'element_type', 'accept_type'], 'integer'],
            [['element', 'accept_params'], 'string', 'max' => 255],
            [[ 'test_item_id', 'element', 'accept_type', 'accept_params'], 'trim'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'            => 'ID',
            'test_item_id'  => '测试项id',
            'element_type'  => '查找类型',
            'element'       => '查找元素',
            'accept_type'   => '期望类型',
            'accept_params' => '期望数据',
            'is_delete'     => '是否删除',
            'created_at'    => '创建时间',
            'updated_at'    => '更新时间',
        ];
    }
}
