<template>
    <div>
        <el-breadcrumb separator="/" class="pd10">
            <el-breadcrumb-item :to="{ path: '/project' }">项目列表</el-breadcrumb-item>
            <el-breadcrumb-item :to="{ path: '/test' }">测试流程</el-breadcrumb-item>
            <el-breadcrumb-item>测试流程编辑</el-breadcrumb-item>
        </el-breadcrumb>
    </div>
</template>



<script>
    export default {
        data() {
            return {

            };
        },
        created() {
            console.log(12222);
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