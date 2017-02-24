<template>
    <div>
        <div>
            <h1>项目编辑</h1>
            <hr/>
        </div>
        <div class="mg20 w600">
            <el-form :model="model" :ref="formName" label-width="100px" >
                <el-form-item :label="labels.name" prop="name" :rules="rules.name" :required="required.name">
                    <el-input v-model="model.name"></el-input>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="submitForm()">保存</el-button>
                    <el-button @click="resetForm()">重置</el-button>
                    <el-button @click="$router.go(-1)">取消</el-button>
                </el-form-item>
            </el-form>
        </div>

    </div>
</template>

<script>
    import projectAjax from 'ajax/projectAjax';

    export default {
        data() {
            return {
                model: {},
                rules: {},
                labels: {},
                required: {},
                formName: ''
            };
        },
        created() {
            projectAjax.formValidate().then(({data}) => {
                if (typeof data.data === 'object') {
                    this.formName = data.data.formName;
                    this.model = data.data.model;
                    this.rules = data.data.validates;
                    this.labels = data.data.labels;
                    this.required = data.data.required;
                }
            });
        },
        methods: {
            submitForm() {
                this.$refs[this.formName].validate((valid) => {
                    if (valid) {
                        console.log('submit!');
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
            resetForm() {
                this.$refs[this.formName].resetFields();
            }
        }
    };
</script>