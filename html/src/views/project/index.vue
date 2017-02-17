<template>
    <div class="project-div" >
        <div class="add">
            <el-button type="primary">添加</el-button>
        </div>

        <el-row class="clearfix" v-if="list.length">
            <el-col :span="10" v-for="(o, index) in 2" :offset="index > 0 ? 2 : 0">
                <el-card>
                    <div class="project-div">
                        <span>好吃的汉堡</span>
                        <div class="bottom clearfix">

                            <template >
                                <el-row>
                                    <el-col :span="6">
                                        xxxxx
                                    </el-col>
                                    <el-col :span="18">
                                        xxxxx
                                    </el-col>
                                    <el-col :span="6">
                                        xxxxx
                                    </el-col>
                                    <el-col :span="18">
                                        xxxxx
                                    </el-col>
                                </el-row>
                            </template>

                            <el-button type="text" class="button">操作按钮</el-button>
                            <el-button type="text" class="button">操作按钮</el-button>
                            <el-button type="text" class="button">操作按钮</el-button>
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
    export default {
        data() {
            return {
                list: [
                    {name: 'xx'}
                ]
            };
        }
    };
</script>