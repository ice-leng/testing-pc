<template>
    <div class="content">
        <el-row class="mgb0">
            <el-col :span="24">
                <div class="top">
                    <div class="title">
                        测试系统
                        <span class="return" v-if="getType() !== 'project'">
                            <router-link :to="{path: '/project'}">
                                返回
                            </router-link>
                        </span>
                    </div>

                </div>
            </el-col>
        </el-row>
        <div class="content-row clearfix">
            <div class="content-left">
                <div class="nav-menu">
                    <v-menu :type="getType()"></v-menu>
                </div>
            </div>
            <div class="content-right">
                <div class="main">
                    <router-view></router-view>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import menu from 'views/layout/menu';
    export default {
        methods: {
            getType() {
                return this.$route.matched[0].name;
            }
        },
        components: {
            vMenu: menu
        }
    };
</script>

<style lang="scss" scoped rel="stylesheet/scss">
    .el-row {
        margin-bottom: 20px;
        &:last-child {
            margin-bottom: 0;
        }
    }
    .el-col {
        border-radius: 4px;
    }
</style>