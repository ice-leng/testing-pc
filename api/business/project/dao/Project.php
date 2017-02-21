<?php

namespace business\project\dao;

use common\helpers\ConstantHelper;
use Yii;
use yii\db\Query;

/**
 * This is the model class for table "project".
 *
 * @property integer $id
 * @property string  $name
 * @property string  $url
 * @property integer $browser
 * @property integer $fixed_bug
 * @property integer $total_case
 * @property integer $total_bug
 * @property integer $total_item
 * @property integer $is_delete
 * @property integer $created_at
 * @property integer $updated_at
 */
class Project extends \business\common\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'url'], 'required'],
            [
                [
                    'browser',
                    'fixed_bug',
                    'total_case',
                    'total_bug',
                    'total_item',
                    'is_delete',
                    'created_at',
                    'updated_at',
                ],
                'integer',
            ],
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
            'id'         => 'ID',
            'name'       => '项目名称',
            'url'        => '当前访问网络地址',
            'browser'    => '浏览器',
            'fixed_bug'  => '已修改bug',
            'total_case' => '总测试用例',
            'total_bug'  => '总bug',
            'total_item' => '总测试项',
            'is_delete'  => '是否删除',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * 获得项目列表
     *
     * @return array []
     */
    public function getProjectList()
    {
        $query = new Query();
        $query->select([
            'id',
            'name',
            'url',
            'browser',
            'fixed_bug',
            'total_case',
            'total_bug',
            'total_item',
            'is_delete',
        ])->from($this->tableName())->where([
            'is_delete' => ConstantHelper::NOT_DELETE,
        ])->orderBy('updated_at desc')->all();
        return $this->page($query);
    }
}
