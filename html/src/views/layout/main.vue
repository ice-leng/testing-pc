<template>
    <el-row>
        <el-col :span="24">
            <div class="grid-content bg-purple-dark">
                <div>测试文子</div>
            </div>
        </el-col>
        <el-col :span="4">
            <div class="grid-content bg-purple-dark">
                <v-menu :type="getType()"></v-menu>
            </div>
        </el-col>

        <el-col :span="20">
            <div class="main">
                <router-view></router-view>
            </div>
        </el-col>
    </el-row>

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

<style lang="scss" rel="stylesheet/scss">
    .el-row {
        margin-bottom: 20px;
        &:last-child {
            margin-bottom: 0;
        }
    }

    .el-col {
        border-radius: 4px;
    }

    .bg-purple-dark {
        background: #58B7FF;
        min-height: 36px;
    }

</style>