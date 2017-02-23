<template>
    <div class="project-div">
        <div class="add">
            <router-link class="button" :to="{path: 'project/edit'}">
                <el-button type="primary" class="button">添加</el-button>
            </router-link>
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
                                    <router-link class="button" :to="{path: 'test', query: { id: l.id }}">
                                        <el-button type="text" class="button">设置测试项</el-button>
                                    </router-link>
                                    <router-link class="button" :to="{path: 'project/edit', query: { id: l.id }}">
                                        <el-button type="text" class="button">编辑</el-button>
                                    </router-link>
                                    <el-button type="text" class="button" @click="projectDelete(l.id)">删除</el-button>
                                </el-col>
                            </el-row>

                        </div>
                    </div>
                </el-card>
            </el-col>
        </el-row>
        <div v-else>
            没有数据哦, 去添加一条吧。
        </div>
    </div>


</template>

<style lang="scss" scoped rel="stylesheet/scss">
    .project-div {
        padding: 14px;
        .add {
            margin: 10px;
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
            projectAjax.projectList().then(({data}) => {
                if (data.data.list.length > 0) {
                    this.list = data.data.list;
                }
            });
        },
        methods: {
            projectDelete(id) {
                console.log(id + 'test');
            }
        }
    };
</script>