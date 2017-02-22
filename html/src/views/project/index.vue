<template>
    <div class="project-div">
        <div class="add">
            <el-button type="primary">添加</el-button>
        </div>

        <el-row class="clearfix" v-if="list.length">
            <el-col :span="10" v-for="(l, index) in list" :offset="index > 0 ? 2 : 0">
                <el-card>
                    <div class="project-div">
                        <span>{{l.name}}(<a target="_blank" :href="l.url">{{l.url}}</a>)</span>
                        <div class="mt10 clearfix">
                            <el-row>
                                <el-col :span="6">
                                    浏览器
                                </el-col>
                                <el-col :span="18">
                                    {{l.browser}}
                                </el-col>
                                <el-col :span="6">
                                    总测试项
                                </el-col>
                                <el-col :span="18">
                                    {{l.total_item}}
                                </el-col>
                                <el-col :span="6">
                                    总测试用例
                                </el-col>
                                <el-col :span="18">
                                    {{l.total_case}}
                                </el-col>
                                <el-col :span="6">
                                    总测试bug
                                </el-col>
                                <el-col :span="18">
                                    {{l.total_bug}}
                                </el-col>
                                <el-col :span="6">
                                    总修复bug
                                </el-col>
                                <el-col :span="18">
                                    {{l.fixed_bug}}
                                </el-col>
                                <el-col :span="24">
                                    <router-link class="button" to="test">
                                        <el-button type="text" class="button">设置测试项</el-button>
                                    </router-link>
                                    <router-link class="button" to="test">
                                        <el-button type="text" class="button">编辑</el-button>
                                    </router-link>
                                    <router-link class="button" to="test">
                                        <el-button type="text" class="button">删除</el-button>
                                    </router-link>
                                </el-col>
                            </el-row>

                        </div>
                    </div>
                </el-card>
            </el-col>
        </el-row>
        <div v-else>
            没有数据哦, 去添加一条。
        </div>
    </div>


</template>

<style lang="scss" scoped rel="stylesheet/scss">
    .project-div {
        padding: 14px;
        .add {
            margin: 10px;
            color: red;
            padding: 0;
            text-align: right;

        }
    }

</style>

<script>
    import projectAjax from 'ajax/projectAjax';

    export default {
        data() {
            return {
                list: []
            };
        },
        created() {
            projectAjax.demoList().then(({data}) => {
                this.list = data.data.list;
            });
        }
    };
</script>