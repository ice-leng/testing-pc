<template>
    <div>
        <el-breadcrumb separator="/" class="pd10">
            <el-breadcrumb-item :to="{ path: '/project' }">项目列表</el-breadcrumb-item>
            <el-breadcrumb-item :to="{ path: '/test' }">测试流程</el-breadcrumb-item>
            <el-breadcrumb-item>测试流程编辑</el-breadcrumb-item>
        </el-breadcrumb>

        <div class="mg20 ">
            <el-form v-if="isLoad" :model="model.flow" :ref="formName.flow" :rules="rules.flow" label-width="160px">
                <el-form-item :label="labels.flow.name || 'name'" prop="name" :required="required.flow.name"
                              :error="error.flow.name">
                    <el-input v-model="model.flow.name" placeholder=""></el-input>
                </el-form-item>

                <el-form-item :label="labels.flow.order || 'order'" prop="order" :required="required.flow.order"
                              :error="error.flow.order">
                    <el-input v-model="model.flow.order" placeholder=""></el-input>
                </el-form-item>

                <el-form-item :label="labels.flow.before_flow || 'before_flow'" prop="before_flow"
                              :required="required.flow.before_flow" :error="error.flow.before_flow">
                    <el-tag
                            :key="tag"
                            v-for="tag in showFlow"
                            :closable="true"
                            :close-transition="false"
                            type="primary"
                            @close="handleClose(tag)"
                    >
                        {{tag.text}}
                    </el-tag>
                    <el-dialog :title="labels.flow.before_flow || 'before_flow'" :visible.sync="dialogVisible"
                               size="tiny">
                        <el-tag
                                :key="tag2.id"
                                v-for="tag2 in beforeFlow"
                                :type="tag2.type"
                                class="tag-dialog"
                        >
                            <div @click="dialogClick(tag2.id)">{{tag2.text}}</div>
                        </el-tag>
                        <span slot="footer" class="dialog-footer">
                            <el-button @click="dialogCancel">取 消</el-button>
                            <el-button type="primary" @click="dialogSure">确 定</el-button>
                        </span>
                    </el-dialog>
                    <el-button class="button-new-tag" size="small" @click="addBeforeWorkflow">+ 添加流程</el-button>
                </el-form-item>

                <el-form-item label="测试项">
                    <el-collapse accordion v-if="this.showItem.length > 0" :value="itemOpen">
                        <el-collapse-item v-for="(item, i) in showItem" :name="i">
                            <template slot="title">{{item.name}}</template>
                            <div class="tag-dialog right" @click="deleteItem(item)">
                                <i class="el-icon-delete"></i>
                            </div>
                            <div class="clearfix"></div>
                            <el-form
                                    v-if="isLoad"
                                    :model="item"
                                    :ref="formName.item+i"
                                    :rules="rules.item"
                                    :inline=true
                            >

                                <el-form-item :label="labels.item.name || 'name'" prop="name"
                                              :required="required.item.name"
                                              :error="error.item.name">
                                    <el-input v-model="item.name" placeholder=""></el-input>
                                </el-form-item>

                                <el-form-item :label="labels.item.type || 'browser'" prop="browser"
                                              :error="error.item.type">
                                    <el-select v-model="item.type" placeholder="类型" :change="changeItemType(item.type, i)">
                                        <el-option v-for="itemType in itemTypes" :label="itemType.text"
                                                   :value="itemType.id"></el-option>
                                    </el-select>
                                </el-form-item>

                                <el-form-item :label="labels.item.url || 'url'" prop="url" :required="required.item.url"
                                              :error="error.item.url">
                                    <el-input :disabled="itemUrlStatus" v-model="item.url" placeholder=""></el-input>
                                </el-form-item>

                            </el-form>
                        </el-collapse-item>
                    </el-collapse>
                    <el-button class="button-new-tag" size="small" @click="addItem()">+ 添加测试项</el-button>
                </el-form-item>


                <el-form-item>
                    <el-button type="primary" @click="search()">保存</el-button>
                    <el-button type="info" @click="search()" :disabled="isCreateCase">生成测试用例</el-button>
                    <el-button type="success" @click="search()" :disabled="isRun">运行</el-button>
                    <el-button @click="$router.go(-1)">取消</el-button>
                </el-form-item>
            </el-form>
        </div>

    </div>
</template>

<style lang="scss" scoped rel="stylesheet/scss">
    .tag-dialog {
        margin-right: 5px;
        cursor: pointer;
    }
</style>


<script>
    import testAjax from 'ajax/testAjax';
    import jsonHelper from 'configs/helpers/jsonHelper';

    export default {
        data() {
            return {
                model: {},
                rules: {},
                labels: {},
                required: {},
                error: {},
                isLoad: false,
                isCreateCase: true,
                isRun: true,
                dialogVisible: false,
                showFlow: [],
                showItem: [],
                showCase: [],
                showAccept: [],
                beforeFlow: [],
                defaultFlow: [],
                itemTypes: [],
                itemOpen: [],
                formName: {},
                itemUrlStatus: false
            };
        },
        created() {
            testAjax.testWorkflowFormValidate({
                id: this.$route.query.id
            }).then(({data}) => {
                if (typeof data.data === 'object') {
                    let validates = data.data;
                    let count = ['flow', 'item', 'case', 'accept'];
                    for (let name in validates) {
                        let validate = validates[name];
                        if (count.indexOf(name) < 0) continue;
                        this.formName[name] = validate.formName;
                        this.model[name] = validate.model;
                        this.rules[name] = jsonHelper.resetPattern(validate.validates);
                        this.labels[name] = validate.labels;
                        this.required[name] = validate.required;
                        this.error[name] = {};
                    }
                    this.showFlow = this.model.flow.before_flow;
                    this.showItem = validates.itemNum === 0 ? [] : this.model.item;
                    this.showCase = validates.caseNum === 0 ? [] : this.model.case;
                    this.showAccept = validates.acceptNum === 0 ? [] : this.model.accept;
                    this.itemTypes = validates.itemTypes;
                    if (this.$route.query.id > 0) {
                        this.isCreateCase = false;
                        this.isRun = false;
                    }
                    this.isLoad = true;
                }
            });
        },
        methods: {
            addBeforeWorkflow() {
                this.dialogVisible = true;
                testAjax.testWorkflowName().then(({data}) => {
                    if (typeof data.data === 'object') {
                        let dialog = data.data;
                        let beforeFlow = this.model.flow.before_flow;
                        for (let i = 0; i < dialog.length; i++) {
                            let type = 'primary';
                            for (let j = 0; j < beforeFlow.length; j++) {
                                if (dialog[i]['id'] === beforeFlow[j]['id']) {
                                    type = '';
                                }
                            }
                            dialog[i]['type'] = type;
                        }
                        this.beforeFlow = dialog;
                        this.defaultFlow = dialog;
                    }
                });
            },
            dialogClick(id) {
                let dialog = this.beforeFlow;
                let type = '';
                for (let i = 0; i < dialog.length; i++) {
                    if (dialog[i]['id'] === id) {
                        if (dialog[i]['type'] === '') {
                            type = 'primary';
                        }
                        dialog[i]['type'] = type;
                    }
                }
                this.beforeFlow = dialog;
            },
            dialogSure() {
                let dialog = this.beforeFlow;
                this.model.flow.before_flow = [];
                for (let i = 0; i < dialog.length; i++) {
                    if (dialog[i]['type'] !== 'primary') {
                        delete dialog[i]['type'];
                        this.model.flow.before_flow.push(dialog[i]);
                    }
                }
                this.showFlow = this.model.flow.before_flow;
                this.dialogVisible = false;
            },
            dialogCancel() {
                this.dialogVisible = false;
                this.beforeFlow = this.defaultFlow;
            },
            handleClose(tag) {
                this.model.flow.before_flow.splice(this.model.flow.before_flow.indexOf(tag), 1);
                this.showFlow = this.model.flow.before_flow;
            },
            addItem() {
                let defaultData = this.model.item[0];
                let data = {};
                for (let i in defaultData) {
                    data[i] = '';
                }
                this.showItem.push(data);
            },
            deleteItem(item) {
                this.showItem.splice(this.showItem.indexOf(item), 1);
            },
            changeItemType(id, i) {
                if (id === '') return;
                if (id === 1) {
                    this.itemUrlStatus = false;
                } else {
                    this.itemUrlStatus = true;
                    this.showItem[i]['url'] = '';
                }
            }
        }
    };
</script>