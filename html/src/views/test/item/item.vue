<template>
    <div class="item-div">
        <div class="add">
            <router-link class="button" :to="{path: 'project/edit'}">
                <el-button type="primary" class="button">添加</el-button>
            </router-link>
        </div>


        <el-button type="text" @click="dialogVisible = true">点击打开 Dialog</el-button>

        <el-dialog
                title="提示"
                :visible.sync="dialogVisible"
                size="tiny"
                :before-close="handleClose">
            <span>这是一段信息</span>
            <span slot="footer" class="dialog-footer">
    <el-button @click="dialogVisible = false">取 消</el-button>
    <el-button type="primary" @click="dialogVisible = false">确 定</el-button>
  </span>
        </el-dialog>


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
                dialogVisible: false
            };
        },
        created() {
            console.log(1);
        },
        methods: {
            handleClose(done) {
                this.$confirm('确认关闭？')
                    .then(_ => {
                        done();
                    })
                    .catch(_ => {});
            }
        }
    };
</script>