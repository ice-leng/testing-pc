<template>
    <div class="item-div">
        <div class="add">
            <router-link class="button" :to="{path: 'project/edit'}">
                <el-button type="primary" class="button">添加</el-button>
            </router-link>
        </div>

        sdf
    </div>
</template>


<style lang="scss" scoped rel="stylesheet/scss">
    .item-div {
        padding: 14px;
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

            };
        },
        created() {
            console.log(1);
        }
    };
</script>