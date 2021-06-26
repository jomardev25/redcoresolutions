<template>
    <div v-if="levelList" class="breadcrumb">
        <transition-group name="breadcrumb">
            <template v-for="(item, index) in levelList">
                <span class="breadcrumb-item" :key="item.path">
                    <span v-if="item.redirect === 'noRedirect' || index === levelList.length-1" class="no-redirect">
                        {{ item.meta.breadcrumbTitle }}
                    </span>
                    <a v-else @click.prevent="handleLink(item)" class="with-redirect">{{ item.meta.breadcrumbTitle }}</a>
                </span>
                <span v-if="index !==levelList.length-1" class="breadcrumb-separator" :key="index">/</span>
            </template>
        </transition-group>
    </div>
</template>
<script>
import pathToRegexp from "path-to-regexp";
export default {
    name: "Breadcrumb",
    data(){
        return {
            levelList: null
        };
    },
    watch: {
        $route(route){
            if (route.path.startsWith("/redirect/")) {
                return;
            }
            this.getBreadcrumb();
        }
    },
    created(){
        this.getBreadcrumb();
    },
    methods: {
        getBreadcrumb(){
            let matched = this.$route.matched.filter(item => item.meta && item.meta.breadcrumbTitle);
            const first = matched[0];

            if (!this.isDashboard(first)) {
                matched = [{ path: "/admin/dashboard", meta: { breadcrumbTitle: "Dashboard" }}].concat(matched);
            }

            this.levelList = matched.filter(item => item.meta && item.meta.breadcrumbTitle && item.meta.breadcrumb !== false);
        },
        isDashboard(route){
            const name = route && route.name;
            if (!name) {
                return false;
            }
            return name.trim().toLocaleLowerCase() === "dashboard".toLocaleLowerCase();
        },
        pathCompile(path){
            const { params } = this.$route;
            const toPath = pathToRegexp.compile(path);
            return toPath(params);
        },
        handleLink(item){
            const { redirect, path } = item;
            if (redirect) {
                this.$router.push(redirect);
                return;
            }
            this.$router.push(this.pathCompile(path));
        }
    }
};
</script>
