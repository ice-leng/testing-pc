<template>
    <div class="item-div">
        <el-breadcrumb separator="/">
            <el-breadcrumb-item :to="{ path: '/project' }">项目列表</el-breadcrumb-item>
            <el-breadcrumb-item>测试流程</el-breadcrumb-item>
        </el-breadcrumb>
        <div class="add">
            <router-link class="button" :to="{path: '/test/edit', query: { pid: this.$route.query.id }}">
                <el-button type="primary" class="button">添加</el-button>
            </router-link>
        </div>
        <el-form label-width="80px" :inline="true">
            <el-form-item label="流程名称">
                <el-input v-model="name"></el-input>
            </el-form-item>

            <el-form-item>
                <el-button type="primary" @click="list()">搜索</el-button>
            </el-form-item>
        </el-form>

        <el-table
                v-loading.body="tLoad"
                :data="tableData.list"
                stripe
                border
                style="width: 100%">
            <el-table-column type="expand">
                <template scope="props">
                    <el-form label-position="left" inline class="demo-table-expand" v-for="(d, i) in props.row.items">
                        <el-form-item label="测试项名称:">
                            <span>{{ d.name }}</span>
                        </el-form-item>
                        <el-form-item label="测试项前置流程名称:">
                            <span>{{ d.before_item }}</span>
                        </el-form-item>
                        <el-form-item label="访问类型:">
                            <span>{{ d.type }}</span>
                        </el-form-item>
                        <el-form-item label="URL:">
                            <span>{{ d.url }}</span>
                        </el-form-item>
                    </el-form>
                </template>
            </el-table-column>
            <el-table-column
                    prop="name"
                    label="流程名称">
            </el-table-column>
            <el-table-column
                    prop="total_case"
                    label="总测试用例">
            </el-table-column>
            <el-table-column
                    prop="total_bug"
                    label="总测试bug">
            </el-table-column>
            <el-table-column
                    prop="fixed_bug"
                    label="已修改bug">
            </el-table-column>
            <el-table-column
                    prop="order"
                    label="排序">
            </el-table-column>
            <el-table-column
                    prop="is_exe"
                    label="是否执行测试">
            </el-table-column>

            <el-table-column
                    fixed="right"
                    label="操作">
                <template scope="scope">
                    <el-button @click="runFlow(scope.row.id, scope.row.is_exe )" type="text" size="small">
                        {{scope.row.is_exe === '激活' ? '取消' : '激活'}}测试
                    </el-button>
                    <el-button @click="editFlow(scope.row.id)" type="text" size="small">编辑</el-button>
                    <el-button @click="deleteFlow(scope.row.id)" type="text" size="small">删除</el-button>
                </template>
            </el-table-column>
        </el-table>
        <page v-if="pLoad" class="mt10 text-center" @change="list" :data="tableData"></page>
    </div>
</template>


<style lang="scss" scoped rel="stylesheet/scss">
    .item-div {
        padding: 10px;
        .add {
            margin: 10px;
            padding: 0;
            text-align: right;
        }
    }

</style>

<script>
    import page from 'components/page';
    import testAjax from 'ajax/testAjax';

    export default {
        data() {
            return {
                name: '',
                tableData: {},
                tLoad: true,
                pLoad: false
            };
        },
        created() {
            this.list();
        },
        methods: {
            list(page) {
                let params = {'pid': this.$route.query.id};
                page = page || -1;
                if (page > 0) {
                    params['page'] = page;
                }
                if (this.name) {
                    params['name'] = this.name;
                }
                testAjax.testWorkflowList(params).then(({data}) => {
                    this.tableData = data.data;
                    this.pLoad = true;
                    this.tLoad = false;
                });
            },
            runFlow(id, status) {
                testAjax.changeRunStatus({
                    id: id
                }).then(({data}) => {
                    this.$message({
                        message: '编辑成功!',
                        type: 'success'
                    });
                    let s = status === '激活' ? '取消' : '激活';
                    let list = this.tableData.list;
                    for (let i in list) {
                        if (list[i]['id'] === id) {
                            list[i]['is_exe'] = s;
                            this.tableData.list[i] = list[i];
                        }
                    }
                });
            },
            editFlow(id) {
                this.$router.push({path: '/test/edit', query: {pid: this.$route.query.id, id: id}});
            },
            deleteFlow(id) {
                this.$confirm('此操作将永久删除该文件, 是否继续？', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    testAjax.testWorkflowDelete({
                        id: id
                    }).then((res) => {
                        this.$message({
                            message: '删除成功!',
                            type: 'success'
                        });
                        let list = this.tableData.list;
                        for (let i in list) {
                            if (list[i]['id'] === id) {
                                this.tableData.list.splice(this.tableData.list.indexOf(this.tableData.list[i]), 1);
                            }
                        }
                    });
                }).catch(() => {

                });
                console.log(id + 'c');
            }
        },
        components: {
            page
        }
    };
</script>