<?php

namespace business\test\dao;

use Yii;

/**
 * This is the model class for table "test_item".
 *
 * @property integer $id
 * @property integer $test_workflow_id
 * @property string  $name
 * @property integer $type
 * @property string  $url
 * @property integer $is_delete
 * @property integer $created_at
 * @property integer $updated_at
 */
class TestItem extends \business\common\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'test_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'name', 'type'], 'required'],
            [['test_workflow_id', 'type'], 'integer'],
            [['name'], 'string', 'max' => 32],
            [['url'], 'string', 'max' => 255],
            [['url'], 'url', 'defaultScheme' => 'http'],
            [['url', 'id', 'name', 'type', 'test_workflow_id'], 'trim'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'               => 'ID',
            'test_workflow_id' => '流程id',
            'name'             => '名称',
            'type'             => '访问类型',
            'url'              => '访问网络地址',
            'is_delete'        => '是否删除',
            'created_at'       => '创建时间',
            'updated_at'       => '更新时间',
        ];
    }
}
