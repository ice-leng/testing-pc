<?php

namespace business\project\dao;

use common\helpers\CodeHelper;
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
            [['name', 'url', 'browser'], 'required'],
            [
                [
                    'browser',
                    'fixed_bug',
                    'total_case',
                    'total_bug',
                    'total_item',
                ],
                'integer',
            ],
            [['name'], 'string', 'max' => 32],
            [['url', 'id', 'name'], 'trim'],
            [['url'], 'string', 'max' => 255],
            [['url'], 'url', 'defaultScheme' => 'http'],
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
        ])->from($this->tableName())->where([
            'is_delete' => ConstantHelper::NOT_DELETE,
        ])->orderBy('updated_at desc')->all();
        return $this->page($query);
    }

    /**
     * 通过id获得项目信息
     *
     * @param int $id 项目id
     *
     * @return array|null|\yii\db\ActiveRecord
     * @author lengbin(lengbin0@gmail.com)
     */
    public function getProjectById($id)
    {
        return $this->find()->where([
            'id'        => $id,
            'is_delete' => ConstantHelper::NOT_DELETE,
        ])->one();
    }

    /**
     * 更新 / 添加 项目
     *
     * @param array $params [id => '', name => '', url => '', browser => '']
     *
     * @return object
     * @author lengbin(lengbin0@gmail.com)
     */
    public function updateProject(array $params)
    {
        if (isset($params['id']) && !empty($params['id'])) {
            $project = $this->getProjectById($params['id']);
            if (empty($project)) {
                $this->invalidParamException();
            }
        }else{
            $project = new Project();
        }
        $project->setAttributes($params);
        $project->save();
        return $project;
    }

}
