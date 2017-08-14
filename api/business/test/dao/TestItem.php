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
            [['name', 'type'], 'required'],
            [['test_workflow_id', 'type', 'project_id'], 'integer'],
            [['name'], 'string', 'max' => 32],
            [['url'], 'string', 'max' => 255],
            [['url'], 'url', 'defaultScheme' => 'http'],
            ['before_item', 'safe'],
            [['id', 'url', 'name', 'type', 'test_workflow_id', 'before_item', 'project_id'], 'trim'],
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
            'project_id'       => '项目id',
            'before_item'      => '前置测试项',
            'name'             => '名称',
            'type'             => '访问类型',
            'url'              => '访问网络地址',
            'is_delete'        => '是否删除',
            'created_at'       => '创建时间',
            'updated_at'       => '更新时间',
        ];
    }

    /**
     * 通过测试流程id获得测试流程项信息
     *
     * @param int $workflowId
     *
     * @return mixed
     * @author lengbin(lengbin0@gmail.com)
     */
    public function getTestItemByWorkflowId($workflowId)
    {
        return $this->find()->select([
            'id',
            'test_workflow_id',
            'before_item',
            'name',
            'type',
            'url',
        ])->where([
            'test_workflow_id' => $workflowId,
        ])->all();
    }

    /**
     * 通过项目id 获得所有测试项
     *
     * @param $pid
     * @param $id
     *
     * @return mixed
     * @author lengbin(lengbin0@gmail.com)
     */
    public function getTestItemByProjectId($pid, $id = 0)
    {
        $itmes = $this->find()->where([
            'project_id' => $pid,
            'is_delete'  => 0,
        ]);
        if ($id > 0) {
            $itmes->andFilterCompare('id', $id, '<');
        }
        return $itmes->all();
    }

    /**
     * 通过id 获得所有测试项
     *
     * @param $id
     * @param $isDelete
     *
     * @return mixed
     * @author lengbin(lengbin0@gmail.com)
     */
    public function getTestItemById($id, $isDelete = true)
    {
        $model = $this->find()->where([
            'id' => $id,
        ]);
        if ($isDelete) {
            $model->andWhere([
                'is_delete' => 0,
            ]);
        }
        return $model->one();
    }

    public function getSetCases()
    {
        return $this->hasMany(TestSetCase::className(), ['test_item_id' => 'id']);
    }

    public function getAccepts()
    {
        return $this->hasMany(TestAccept::className(), ['test_item_id' => 'id']);
    }

    /**
     * 通过流程id 删除 测试项
     *
     * @param int $workflowId 流程id
     *
     * @author lengbin(lengbin0@gmail.com)
     */
    public function deleteTestItem($workflowId)
    {
        TestItem::updateAll([
            'is_delete' => 1,
        ], [
            'test_workflow_id' => $workflowId,
        ]);
    }

    /**
     * 添加 测试项
     *
     * @param array $params    ['url', 'name', 'type', 'test_workflow_id']
     * @param array $testItems [[1=>name]]
     *
     * @return object
     * @author lengbin(lengbin0@gmail.com)
     */
    public function updateTestItem(array $params, array $testItems)
    {
        if (isset($params['id']) && !empty($params['id'])) {
            $item = $this->getTestItemById($params['id'], false);
            if (empty($item)) {
                $this->invalidParamException('测试项id不存在');
            }
            $item->is_delete = 0;
        } else {
            $item = new TestItem();
        }
        if (isset($params['before_item']) && is_array($params['before_item'])) {
            $ids = [];
            foreach ($params['before_item'] as $tItem) {
                $id = isset($tItem['id']) ? $tItem['id'] : 0;
                if (!isset($testItems[$id]) || empty($testItems[$id])) {
                    $this->invalidParamException("前置测试项【{$tItem['text']}】不存在");
                }
                $ids[] = $id;
            }
            $bf = implode(',', $ids);
            $params['before_item'] = $bf;
        }
        $item->setAttributes($params);
        $item->save();
        return $item;
    }
}
