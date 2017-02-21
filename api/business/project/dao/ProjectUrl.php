<?php

namespace business\project\dao;

use Yii;

/**
 * This is the model class for table "project_url".
 *
 * @property integer $id
 * @property integer $project_id
 * @property string $name
 * @property string $url
 * @property integer $is_delete
 * @property integer $created_at
 * @property integer $updated_at
 */
class ProjectUrl extends \business\common\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project_url';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id', 'name', 'url', 'created_at', 'updated_at'], 'required'],
            [['project_id', 'is_delete', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 32],
            [['url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'project_id' => '项目id',
            'name' => '项目名称',
            'url' => '访问网络地址',
            'is_delete' => '是否删除',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }
}
