<template>
    <div class="block">
        <el-pagination
                @current-change="handleCurrentChange"
                :current-page="parseInt(data.currentPage)"
                :page-size="parseInt(data.pageSize)"
                :total="parseInt(data.totalCount)"
                layout=" prev, pager, next, jumper, total"
        >
        </el-pagination>
    </div>
</template>

<script>
    export default {
        props: {
            data: {
                type: Object,
                default() {
                    return {
                        currentPage: 1,
                        pageSize: 1,
                        totalCount: 1
                    };
                }
            }
        },
        methods: {
            handleCurrentChange(val) {
                this.$emit('change', val);
            }
        }
    };
</script>
