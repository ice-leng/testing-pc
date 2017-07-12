<template>
    <div class="item-div">
        <el-breadcrumb separator="/">
            <el-breadcrumb-item :to="{ path: '/project' }">项目列表</el-breadcrumb-item>
            <el-breadcrumb-item>测试流程</el-breadcrumb-item>
        </el-breadcrumb>
        <div class="add">
            <router-link class="button" :to="{path: '/test/edit'}">
                <el-button type="primary" class="button">添加</el-button>
            </router-link>
        </div>
        <el-form label-width="80px" :inline="true">
            <el-form-item label="流程名称">
                <el-input v-model="name"></el-input>
            </el-form-item>

            <el-form-item>
                <el-button type="primary" @click="search()">搜索</el-button>
            </el-form-item>
        </el-form>

        <el-table
                :data="tableData"
                stripe
                border
                style="width: 100%">
            <el-table-column
                    type="expand"
                    prop="name"
                    label="姓名">
                <template scope="props">
                    <el-form label-position="left" inline class="demo-table-expand">
                        <el-form-item label="商品名称">
                            <span>{{ props.row.data.name }}</span>
                        </el-form-item>
                        <el-form-item label="所属店铺">
                            <span>{{ props.row.data.name }}</span>
                        </el-form-item>
                        <el-form-item label="商品 ID">
                            <span>{{ props.row.data.name }}</span>
                        </el-form-item>
                        <el-form-item label="店铺 ID">
                            <span>{{ props.row.data.name }}</span>
                        </el-form-item>
                        <el-form-item label="商品分类">
                            <span>{{ props.row.data.name }}</span>
                        </el-form-item>
                        <el-form-item label="店铺地址">
                            <span>{{ props.row.data.name }}</span>
                        </el-form-item>
                        <el-form-item label="商品描述">
                            <span>{{ props.row.data.name }}</span>
                        </el-form-item>
                    </el-form>
                </template>
            </el-table-column>
            <el-table-column
                    prop="address"
                    label="测试项">
            </el-table-column>
            <el-table-column
                    prop="22"
                    label="测试用例">
            </el-table-column>
            <el-table-column
                    prop="22"
                    label="测试bug">
            </el-table-column>
            <el-table-column
                    prop="22"
                    label="已修改bug">
            </el-table-column>
            <el-table-column
                    prop="22"
                    label="排序">
            </el-table-column>

            <el-table-column
                    fixed="right"
                    label="操作">
                <template scope="scope">
                    <el-button @click="deleteFlow(scope.row.id)" type="text" size="small">运行</el-button>
                    <el-button @click="deleteFlow(scope.row.id)" type="text" size="small">编辑</el-button>
                    <el-button @click="deleteFlow(scope.row.id)" type="text" size="small">删除</el-button>
                    <el-button @click="deleteFlow(scope.row.id)" type="text" size="small">编辑</el-button>
                </template>
            </el-table-column>
        </el-table>


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
    export default {
        data() {
            return {
                name: '',
                tableData: [{
                    data: {name: 123},
                    id: 1,
                    date: '2016-05-02',
                    name: '王小虎',
                    address: '上海市普陀区金沙江路 1518 弄'
                }, {
                    data: {name: 123},
                    id: 2,
                    date: '2016-05-04',
                    name: '王小虎',
                    address: '上海市普陀区金沙江路 1517 弄'
                }, {
                    data: {name: 123},
                    id: 3,
                    date: '2016-05-01',
                    name: '王小虎',
                    address: '上海市普陀区金沙江路 1519 弄'
                }, {
                    data: {name: 123},
                    id: 4,
                    date: '2016-05-03',
                    name: '王小虎',
                    address: '上海市普陀区金沙江路 1516 弄'
                }]
            };
        },
        created() {
            console.log(1);
        },
        methods: {
            search() {
                console.log(222);
            },
            deleteFlow(id) {
                console.log(id);
            }
        }
    };
</script>