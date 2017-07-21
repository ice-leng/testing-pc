<template>
    <div>
        <el-breadcrumb separator="/" class="pd10">
            <el-breadcrumb-item :to="{ path: '/project' }">项目列表</el-breadcrumb-item>
            <el-breadcrumb-item :to="{ path: '/test' }">测试流程</el-breadcrumb-item>
            <el-breadcrumb-item>测试流程编辑</el-breadcrumb-item>
        </el-breadcrumb>

        <div class="mg20">
            <!-- flow start -->
            <el-form v-if="isLoad" :model="model.flow" :ref="formName.flow" :rules="rules.flow" label-width="70px">
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
                <!-- flow end -->
                <!-- item start -->
                <el-form-item label="测试项" :required="required.flow.name" :error="itemError">
                    <el-collapse v-if="this.showItem.length > 0" :value="itemOpen">
                        <el-collapse-item v-for="(item, i) in showItem" :name="i">
                            <template slot="title">{{item.name}}</template>
                            <div class="tag-dialog right" @click="deleteItem(item, i)">
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
                                              :error="error.item[i].name">
                                    <el-input v-model="item.name" placeholder=""></el-input>
                                </el-form-item>

                                <el-form-item :label="labels.item.type || 'type'" prop="type"
                                              :error="error.item[i].type">
                                    <el-select v-model="item.type" placeholder="类型"
                                               :change="changeItemType(item.type, i)">
                                        <el-option v-for="itemType in itemTypes" :label="itemType.text"
                                                   :value="itemType.id"></el-option>
                                    </el-select>
                                </el-form-item>

                                <el-form-item :label="labels.item.url || 'url'" prop="url" :required="required.item.url"
                                              :error="error.item[i].url">
                                    <el-input :disabled="itemUrlStatus[i]" v-model="item.url" placeholder=""></el-input>
                                </el-form-item>

                            </el-form>
                            <!-- item end -->
                            <!-- set case start -->
                            <div class="mt10">
                                <div class="left">用例设置</div>
                                <div class="right">
                                    <el-button class="button-new-tag" size="small" @click="addCase(item.id, i)">
                                        + 添加用例设置
                                    </el-button>
                                </div>
                                <div class="clearfix"></div>
                                <el-table
                                        class="mt10"
                                        :data="showCase[(item.id !== '' ? item.id : i)]"
                                        border
                                        style="width: 100%">
                                    <el-table-column :label="labels.setCase.name" width="140">
                                        <template scope="scope">
                                            <div class="tCell">
                                                <el-form
                                                        v-if="isLoad"
                                                        :model="scope.row"
                                                        :ref="formName.setCase+(item.id !== '' ? item.id : i)+scope.$index"
                                                        :rules="rules.setCase"
                                                >
                                                    <el-form-item prop="name"
                                                                  :error="error.setCase[(item.id !== '' ? item.id : i)][scope.$index]['name']">
                                                        <el-input v-model="scope.row.name" placeholder=""></el-input>
                                                    </el-form-item>
                                                </el-form>
                                            </div>
                                        </template>
                                    </el-table-column>
                                    <el-table-column :label="labels.setCase.event_type" width="140">
                                        <template scope="scope">
                                            <div class="tCell">
                                                <el-form
                                                        v-if="isLoad"
                                                        :model="scope.row"
                                                        :ref="formName.setCase+(item.id !== '' ? item.id : i)+scope.$index"
                                                        :rules="rules.setCase"
                                                >
                                                    <el-form-item prop="event_type"
                                                                  :error="error.setCase[(item.id !== '' ? item.id : i)][scope.$index]['event_type']">
                                                        <el-select v-model="scope.row.event_type" placeholder="事件类型">
                                                            <el-option v-for="eventType in eventTypes"
                                                                       :label="eventType.text"
                                                                       :value="eventType.id"></el-option>
                                                        </el-select>
                                                    </el-form-item>
                                                </el-form>
                                            </div>
                                        </template>
                                    </el-table-column>
                                    <el-table-column :label="labels.setCase.element_type" width="140">
                                        <template scope="scope">
                                            <div class="tCell">
                                                <el-form
                                                        v-if="isLoad"
                                                        :model="scope.row"
                                                        :ref="formName.setCase+(item.id !== '' ? item.id : i)+scope.$index"
                                                        :rules="rules.setCase"
                                                >
                                                    <el-form-item prop="element_type"
                                                                  :error="error.setCase[(item.id !== '' ? item.id : i)][scope.$index]['element_type']">
                                                        <el-select v-model="scope.row.element_type" placeholder="查找类型">
                                                            <el-option v-for="elementType in elementTypes"
                                                                       :label="elementType.text"
                                                                       :value="elementType.id"></el-option>
                                                        </el-select>
                                                    </el-form-item>
                                                </el-form>
                                            </div>
                                        </template>
                                    </el-table-column>
                                    <el-table-column :label="labels.setCase.element" width="210">
                                        <template scope="scope">
                                            <div class="tCell">
                                                <el-form
                                                        v-if="isLoad"
                                                        :model="scope.row"
                                                        :ref="formName.setCase+(item.id !== '' ? item.id : i)+scope.$index"
                                                        :rules="rules.setCase"
                                                >
                                                    <el-form-item prop="element"
                                                                  :error="error.setCase[(item.id !== '' ? item.id : i)][scope.$index]['element']">
                                                        <el-input v-model="scope.row.element" placeholder=""></el-input>
                                                    </el-form-item>
                                                </el-form>
                                            </div>
                                        </template>
                                    </el-table-column>
                                    <el-table-column :label="labels.setCase.element_params" width="210">
                                        <template scope="scope">
                                            <div class="tCell">
                                                <el-form
                                                        v-if="isLoad"
                                                        :model="scope.row"
                                                        :ref="formName.setCase+(item.id !== '' ? item.id : i)+scope.$index"
                                                        :rules="rules.setCase"
                                                >
                                                    <el-form-item prop="element_params"
                                                                  :error="error.setCase[(item.id !== '' ? item.id : i)][scope.$index]['element_params']">
                                                        <el-input v-model="scope.row.element_params"
                                                                  placeholder=""></el-input>
                                                    </el-form-item>
                                                </el-form>
                                            </div>
                                        </template>
                                    </el-table-column>
                                    <el-table-column :label="labels.setCase.wait_time" width="210">
                                        <template scope="scope">
                                            <div class="tCell">
                                                <el-form
                                                        v-if="isLoad"
                                                        :model="scope.row"
                                                        :ref="formName.setCase+(item.id !== '' ? item.id : i)+scope.$index"
                                                        :rules="rules.setCase"
                                                >
                                                    <el-form-item prop="wait_time"
                                                                  :error="error.setCase[(item.id !== '' ? item.id : i)][scope.$index]['wait_time']">
                                                        <el-input-number v-model="scope.row.wait_time"
                                                                         placeholder=""></el-input-number>
                                                    </el-form-item>
                                                </el-form>
                                            </div>
                                        </template>
                                    </el-table-column>
                                    <el-table-column :label="labels.setCase.is_required" width="120">
                                        <template scope="scope">
                                            <div class="tCell">
                                                <el-form
                                                        v-if="isLoad"
                                                        :model="scope.row"
                                                        :ref="formName.setCase+(item.id !== '' ? item.id : i)+scope.$index"
                                                        :rules="rules.setCase"
                                                >
                                                    <el-checkbox prop="is_required"
                                                                 v-model="scope.row.is_required"></el-checkbox>
                                                </el-form>
                                            </div>
                                        </template>
                                    </el-table-column>
                                    <el-table-column :label="labels.setCase.is_xss" width="120">
                                        <template scope="scope">
                                            <div class="tCell">
                                                <el-form
                                                        v-if="isLoad"
                                                        :model="scope.row"
                                                        :ref="formName.setCase+(item.id !== '' ? item.id : i)+scope.$index"
                                                        :rules="rules.setCase"
                                                >
                                                    <el-checkbox prop="is_xss" v-model="scope.row.is_xss"></el-checkbox>
                                                </el-form>
                                            </div>
                                        </template>
                                    </el-table-column>
                                    <el-table-column :label="labels.setCase.is_sql" width="120">
                                        <template scope="scope">
                                            <div class="tCell">
                                                <el-form
                                                        v-if="isLoad"
                                                        :model="scope.row"
                                                        :ref="formName.setCase+(item.id !== '' ? item.id : i)+scope.$index"
                                                        :rules="rules.setCase"
                                                >
                                                    <el-checkbox prop="is_sql" v-model="scope.row.is_sql"></el-checkbox>
                                                </el-form>
                                            </div>
                                        </template>
                                    </el-table-column>

                                    <el-table-column label="操作">
                                        <template scope="scope">
                                            <el-button
                                                    size="small"
                                                    type="danger"
                                                    @click="deleteCase(scope.$index, i)">删除
                                            </el-button>
                                        </template>
                                    </el-table-column>
                                </el-table>
                            </div>
                            <!-- set case end -->
                            <!-- accept start -->
                            <div class="mt10">
                                <div class="left">期望设置</div>
                                <div class="right">
                                    <el-button class="button-new-tag" size="small" @click="addAccept(item.id, i)">
                                        + 添加期望设置
                                    </el-button>
                                </div>
                                <div class="clearfix"></div>
                                <el-table
                                        class="mt10"
                                        :data="showAccept[(item.id !== '' ? item.id : i)]"
                                        border
                                        style="width: 100%">
                                    <el-table-column :label="labels.accept.element_type" width="140">
                                        <template scope="scope">
                                            <div class="tCell">
                                                <el-form
                                                        v-if="isLoad"
                                                        :model="scope.row"
                                                        :ref="formName.accept+(item.id !== '' ? item.id : i)+scope.$index"
                                                        :rules="rules.accept"
                                                >
                                                    <el-form-item prop="element_type"
                                                                  :error="error.accept[(item.id !== '' ? item.id : i)][scope.$index]['element_type']">
                                                        <el-select v-model="scope.row.element_type" placeholder="查找类型">
                                                            <el-option v-for="elementType in elementTypes"
                                                                       :label="elementType.text"
                                                                       :value="elementType.id"></el-option>
                                                        </el-select>
                                                    </el-form-item>
                                                </el-form>
                                            </div>
                                        </template>
                                    </el-table-column>
                                    <el-table-column :label="labels.accept.element" width="210">
                                        <template scope="scope">
                                            <div class="tCell">
                                                <el-form
                                                        v-if="isLoad"
                                                        :model="scope.row"
                                                        :ref="formName.accept+(item.id !== '' ? item.id : i)+scope.$index"
                                                        :rules="rules.accept"
                                                >
                                                    <el-form-item prop="element"
                                                                  :error="error.accept[(item.id !== '' ? item.id : i)][scope.$index]['element']">
                                                        <el-input v-model="scope.row.element" placeholder=""></el-input>
                                                    </el-form-item>
                                                </el-form>
                                            </div>
                                        </template>
                                    </el-table-column>
                                    <el-table-column :label="labels.accept.accept_type">
                                        <template scope="scope">
                                            <div class="tCell">
                                                <el-form
                                                        v-if="isLoad"
                                                        :model="scope.row"
                                                        :ref="formName.accept+(item.id !== '' ? item.id : i)+scope.$index"
                                                        :rules="rules.accept"
                                                >
                                                    <el-form-item prop="accept_type"
                                                                  :error="error.accept[(item.id !== '' ? item.id : i)][scope.$index]['accept_type']">
                                                        <el-select v-model="scope.row.accept_type" placeholder="期望类型"
                                                                   size="300">
                                                            <el-option v-for="acceptType in acceptTypes"
                                                                       :label="acceptType.text"
                                                                       :value="acceptType.id"></el-option>
                                                        </el-select>
                                                    </el-form-item>
                                                </el-form>
                                            </div>
                                        </template>
                                    </el-table-column>
                                    <el-table-column :label="labels.accept.accept_params">
                                        <template scope="scope">
                                            <div class="tCell">
                                                <el-form
                                                        v-if="isLoad"
                                                        :model="scope.row"
                                                        :ref="formName.accept+(item.id !== '' ? item.id : i)+scope.$index"
                                                        :rules="rules.accept"
                                                >
                                                    <el-form-item prop="accept_params"
                                                                  :error="error.accept[(item.id !== '' ? item.id : i)][scope.$index]['accept_params']">
                                                        <el-input v-model="scope.row.accept_params"
                                                                  placeholder=""></el-input>
                                                    </el-form-item>
                                                </el-form>
                                            </div>
                                        </template>
                                    </el-table-column>

                                    <el-table-column label="操作">
                                        <template scope="scope">
                                            <el-button
                                                    size="small"
                                                    type="danger"
                                                    @click="deleteAccept(scope.$index, i)">删除
                                            </el-button>
                                        </template>
                                    </el-table-column>
                                </el-table>
                            </div>
                            <!-- accept end -->

                        </el-collapse-item>
                    </el-collapse>
                    <el-button class="button-new-tag" size="small" @click="addItem()">+ 添加测试项</el-button>
                </el-form-item>

                <el-form-item>
                    <el-button type="primary" @click="submit()">保存</el-button>
                    <el-button type="info" @click="create()" :disabled="isCreateCase">生成测试用例</el-button>
                    <el-button type="success" @click="run()" :disabled="isRun">运行</el-button>
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

    .tCell {
        height: 52px;
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
                defaultItem: {},
                defaultCase: {},
                defaultAccept: {},
                beforeFlow: [],
                defaultFlow: [],
                itemTypes: [],
                acceptTypes: [],
                elementTypes: [],
                eventTypes: [],
                itemOpen: [],
                formName: {},
                waitTime: 0,
                itemError: '',
                itemUrlStatus: []
            };
        },
        created() {
            testAjax.testWorkflowFormValidate({
                id: this.$route.query.id,
                pid: this.$route.query.pid
            }).then(({data}) => {
                if (typeof data.data === 'object') {
                    let validates = data.data;
                    let count = ['flow', 'item', 'setCase', 'accept'];
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
                    this.model.flow.project_id = this.$route.query.pid || 0;
                    this.model.flow.id = this.$route.query.id || 0;
                    this.showFlow = this.model.flow.before_flow;
                    this.showItem = validates.itemNum === 0 ? [] : this.model.item;
                    this.showCase = this.model.setCase;
                    this.showAccept = this.model.accept;
                    this.itemTypes = validates.itemTypes;
                    this.eventTypes = validates.eventTypes;
                    this.elementTypes = validates.elementTypes;
                    this.acceptTypes = validates.acceptTypes;
                    this.waitTime = validates.waitTime;
                    this.defaultItem = this.model.item[0];
                    this.isCreateCase = validates.isCreateCase;
                    this.isRun = validates.isRun;
                    for (let t = 0; t < this.model.item.length; t++) {
                        this.error['item'][t] = {};
                    }
                    for (let i in this.model.setCase) {
                        this.error['setCase'][i] = [];
                        for (let j = 0; j < this.model.setCase[i].length; j++) {
                            if (JSON.stringify(this.defaultCase) === '{}') {
                                this.defaultCase = this.model.setCase[i][j];
                            }
                            if (validates.setCaseNum === 0) {
                                this.showCase = [[this.model.setCase[i][j]]];
                            }
                            this.error['setCase'][i].push({});
                        }
                    }
                    for (let m in this.model.accept) {
                        this.error['accept'][m] = [];
                        for (let n = 0; n < this.model.accept[m].length; n++) {
                            if (JSON.stringify(this.defaultAccept) === '{}') {
                                this.defaultAccept = this.model.accept[m][n];
                            }
                            if (validates.acceptNum === 0) {
                                this.showAccept = [[this.model.accept[m][n]]];
                            }
                            this.error['accept'][m].push({});
                        }
                    }
                    this.isLoad = true;
                }
            });
        },
        methods: {
            addBeforeWorkflow() {
                this.dialogVisible = true;
                testAjax.testWorkflowName({
                    pid: this.$route.query.pid
                }).then(({data}) => {
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
                let data = {};
                for (let i in this.defaultItem) {
                    data[i] = '';
                }
                this.showItem.push(data);
                let num = this.showItem.length;
                if (num > 1) {
                    num -= 1;
                    this.addCase('', num);
                    this.addAccept('', num);
                    if (typeof this.error['item'][num] === 'undefined') {
                        this.error['item'][num] = {};
                    }
                }
                this.model.item = this.showItem;
            },
            deleteItem(item, i) {
                this.showItem.splice(this.showItem.indexOf(item), 1);
                this.model.item = this.showItem;
                let id = item.id !== '' ? item.id : i;
                this.showCase.splice(this.showCase.indexOf(this.showCase[id]), 1);
                this.showAccept.splice(this.showAccept.indexOf(this.showAccept[id]), 1);
                this.model.setCase = this.showCase;
                this.model.accept = this.showAccept;
            },
            changeItemType(id, i) {
                if (id === '') return;
                if (id === 1) {
                    this.itemUrlStatus[i] = false;
                } else {
                    this.itemUrlStatus[i] = true;
                    this.showItem[i]['url'] = '';
                }
            },
            addCase(id, index) {
                let errorSetCase;
                let data = {};
                if (id === '') {
                    id = index;
                }
                if (typeof this.showCase[id] === 'undefined') {
                    this.showCase[id] = [];
                }
                if (typeof this.error['setCase'][id] === 'undefined') {
                    this.error['setCase'][id] = [];
                }
                errorSetCase = this.error['setCase'][id];
                for (let i in this.defaultCase) {
                    if (i === 'wait_time') {
                        data[i] = this.waitTime;
                    } else {
                        data[i] = '';
                    }
                }
                this.showCase[id].push(data);
                errorSetCase.push({});
                this.model.setCase = this.showCase;
            },
            deleteCase(index, i) {
                if (typeof this.showCase[i] !== 'undefined') {
                    this.showCase[i].splice(this.showCase[i].indexOf(this.showCase[i][index]), 1);
                    this.error['setCase'][i].splice(this.error['setCase'][i].indexOf(this.error['setCase'][i][index]), 1);
                    this.model.setCase = this.showCase;
                }
            },
            addAccept(id, index) {
                let errorAccept;
                let data = {};
                if (id === '') {
                    id = index;
                }
                if (typeof this.showAccept[id] === 'undefined') {
                    this.showAccept[id] = [];
                }
                if (typeof this.error['accept'][id] === 'undefined') {
                    this.error['accept'][id] = [];
                }
                errorAccept = this.error['accept'][id];
                for (let i in this.defaultAccept) {
                    data[i] = '';
                }
                this.showAccept[id].push(data);
                errorAccept.push({});
                this.model.accept = this.showAccept;
            },
            deleteAccept(index, i) {
                if (typeof this.showAccept[i] !== 'undefined') {
                    this.showAccept[i].splice(this.showAccept[i].indexOf(this.showAccept[i][index]), 1);
                    this.error['accept'][i].splice(this.error['accept'][i].indexOf(this.error['accept'][i][index]), 1);
                    this.model.accept = this.showAccept;
                }
            },
            alert(message, offset) {
                offset = offset || 0;
                this.$notify.error({
                    title: '错误',
                    message: message,
                    offset: offset
                });
            },
            formValidate() {
                let status;
                this.$refs[this.formName.flow].validate((valid) => {
                    let flowStatus = true;
                    let itemStatus = 0;
                    let setCaseStatus = 0;
                    let acceptStatus = 0;
                    this.itemError = '';
                    this.itemOpen = [];
                    // item
                    if (this.showItem.length === 0) {
                        this.itemError = '测试项不能为空';
                        flowStatus = false;
                    }
                    if (!valid) {
                        flowStatus = false;
                    }

                    for (let i = 0; i < this.showItem.length; i++) {
                        let id = this.showItem[i].id || i;
                        if (typeof this.showCase[id] === 'undefined') {
                            setCaseStatus = 1;
                            this.alert('用例设置验证错误，请刷新重新填写');
                        }
                        if (typeof this.showAccept[id] === 'undefined') {
                            acceptStatus = 1;
                            this.alert('期望设置验证错误，请刷新重新填写', 100);
                        }
                        if (setCaseStatus === 1 || acceptStatus === 1) {
                            break;
                        }

                        let iName = this.formName.item + i;
                        this.$refs[iName][0].validate((iValid) => {
                            if (!iValid) {
                                itemStatus = 1;
                            }
                        });

                        for (let s = 0; s < this.showCase[id].length; s++) {
                            let cName = this.formName.setCase;
                            cName = cName + id + s;
                            for (let f = 0; f < this.$refs[cName].length; f++) {
                                this.$refs[cName][f].validate((sValid) => {
                                    if (!sValid) {
                                        setCaseStatus = 2;
                                    }
                                });
                            }
                        }

                        for (let a = 0; a < this.showAccept[id].length; a++) {
                            let aName = this.formName.accept;
                            aName = aName + id + a;
                            for (let n = 0; n < this.$refs[aName].length; n++) {
                                this.$refs[aName][n].validate((aValid) => {
                                    if (!aValid) {
                                        acceptStatus = 2;
                                    }
                                });
                            }
                        }
                        if (itemStatus === 1 || setCaseStatus === 2 || acceptStatus === 2) {
                            if (this.itemOpen.indexOf(i) < 0) {
                                this.itemOpen.push(i);
                            }
                        }
                    }
                    if (!flowStatus || itemStatus > 0 || setCaseStatus > 0 || acceptStatus > 0) {
                        status = false;
                        return false;
                    }
                    status = true;
                });
                return status;
            },
            submit() {
                let status = this.formValidate();
                if (!status) {
                    return status;
                }
                testAjax.testWorkflowUpdate(this.model).then(({data}) => {
                    let id = data.data.id;
                    this.$router.replace({path: '/test/edit', query: {pid: this.$route.query.pid, id: id}});
                    window.location.reload();
                }).catch((data) => {
                    let msg = data.data.message;
                    this.error['flow'] = JSON.parse(msg['flow']);
                    for (let i = 0; i < msg['item'].length; i++) {
                        this.error['item'][i] = JSON.parse(msg['item'][i]);
                        if (this.itemOpen.indexOf(i) < 0) {
                            this.itemOpen.push(i);
                        }
                        for (let n = 0; n < msg['setCase'][i].length; n++) {
                            this.error['setCase'][i][n] = JSON.parse(msg['setCase'][i][n]);
                        }
                        for (let m = 0; m < msg['accept'][i].length; m++) {
                            this.error['accept'][i][m] = JSON.parse(msg['accept'][i][m]);
                        }
                    }
                });
            },
            create() {
                console.log(2);
            },
            run() {
                console.log(1);
            }
        }
    };
</script>