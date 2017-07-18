<template>
    <div>
        <el-breadcrumb separator="/" class="pd10">
            <el-breadcrumb-item :to="{ path: '/project' }">项目列表</el-breadcrumb-item>
            <el-breadcrumb-item>项目编辑</el-breadcrumb-item>
        </el-breadcrumb>
        <div class="mg20 w600">
            <el-form v-if="isLoad" :model="model" :ref="formName" :rules="rules" label-width="160px" >
                <el-form-item :label="labels.name || 'name'" prop="name" :required="required.name"  :error="error.name">
                    <el-input v-model="model.name" placeholder=""></el-input>
                </el-form-item>

                <el-form-item :label="labels.url || 'url'" prop="url" :required="required.url" :error="error.url" >
                    <el-input v-model="model.url" type="url" placeholder="" ></el-input>
                </el-form-item>

                <el-form-item :label="labels.browser || 'browser'" prop="browser" :error="error.browser">
                    <el-select v-model="model.browser" placeholder="请选择浏览器">
                        <el-option v-for="browserType in browserTypes" :label="browserType.text"
                                   :value="browserType.id"></el-option>
                    </el-select>
                </el-form-item>

                <el-form-item>
                    <el-button type="primary" @click="submitForm()">保存</el-button>
                    <el-button @click="$router.go(-1)">取消</el-button>
                </el-form-item>
            </el-form>
        </div>

    </div>
</template>

<script>
    import projectAjax from 'ajax/projectAjax';
    import jsonHelper from 'configs/helpers/jsonHelper';

    export default {
        data() {
            return {
                model: {},
                rules: {},
                labels: {},
                required: {},
                error: {},
                browserTypes: {},
                isLoad: false,
                formName: ''
            };
        },
        created() {
            projectAjax.formValidate({
                id: this.$route.query.id
            }).then(({data}) => {
                if (typeof data.data === 'object') {
                    let validate = data.data.validate;
                    this.formName = validate.formName;
                    this.model = validate.model;
                    this.rules = jsonHelper.resetPattern(validate.validates);
                    this.labels = validate.labels;
                    this.required = validate.required;
                    this.browserTypes = data.data.browserType;
                    this.isLoad = true;
                }
            });
        },
        methods: {
            submitForm() {
                this.$refs[this.formName].validate((valid) => {
                    if (!valid) {
                        return false;
                    }
                    this.error = {};
                    projectAjax.updateProject({
                        id: this.model.id,
                        name: this.model.name,
                        url: this.model.url,
                        browser: this.model.browser
                    }).then((res) => {
                        let msg = '';
                        let _this = this;
                        if (_this.model.id > 0) {
                            msg = '修改成功';
                        } else {
                            msg = '创建成功';
                        }
                        this.$message.success(msg);
                        setTimeout(function () {
                            _this.$router.push('/project');
                        }, 1000);
                    }).catch((data) => {
                        this.error = data.data.message;
                    });
                });
            }
        }
    };
</script>