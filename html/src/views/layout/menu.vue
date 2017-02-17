<template>
    <el-menu mode="vertical" :default-active="getDefaultRouter()" class="el-menu-vertical-demo" :router="true">
        <el-menu-item-group :title="menuList.text">
            <el-menu-item :index="children.path" v-if="menuList.children"
                          v-for="(children, index) in menuList.children">
                <i :class="children.icon ? children.icon : 'el-icon-message'"></i>{{children.text}}
            </el-menu-item>
        </el-menu-item-group>
    </el-menu>
</template>

<script>
    import Menus from 'configs/routers/index';

    export default {
        props: ['type'],
        data() {
            return {
                menuList: '',
                defaultRouter: ''
            };
        },
        methods: {
            getList() {
                let menu;
                for (let i = 0; i < Menus.options.routes.length; ++i) {
                    menu = Menus.options.routes[i];
                    if (menu.name === this.type) break;
                }
                return menu;
            },
            getDefaultRouter() {
                this.menuList = this.getList();
                if (this.menuList.children && this.defaultRouter === '') {
                    this.defaultRouter = this.menuList.children[0].path;
                } else {
                    this.defaultRouter = this.$route.path;
                }
                return this.defaultRouter;
            }

        }
    };
</script>