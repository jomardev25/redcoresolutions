<template>
    <nav class="sidebar">
        <ul class="side-nav">
            <li :class="['side-nav__item', {'side-nav__item--active': $route.name === 'home.index' }]">
                <router-link :to="{ name: 'home.index' }" class="side-nav__link">
                    <i class="fa fa-home side-nav__icon"></i>
                    <span>Home</span>
                </router-link>
            </li>
            <li :class="['side-nav__item', {'side-nav__item--active': isActiveRole}]">
                <router-link :to="{ name: 'roles.index' }" class="side-nav__link">
                    <i class="fa fa-universal-access side-nav__icon"></i>
                    <span>Roles</span>
                </router-link>
            </li>
            <li :class="['side-nav__item', {'side-nav__item--active': isActiveUser }]">
                <router-link :to="{ name: 'users.index' }" class="side-nav__link">
                    <i class="fa fa-users side-nav__icon"></i>
                    <span>Users</span>
                </router-link>
            </li>
        </ul>
        <div class="legal">
            &copy; 2021 by RedCore Solutions. All rights reserved.
        </div>
    </nav>
</template>
<script>
export default {
    name: "Sidebar",
    computed: {
        isActiveRole(){
            const routes = ["roles.index", "roles.create", "roles.edit"];
            return routes.includes(this.$route.name);
        },
        isActiveUser(){
            const routes = ["users.index", "users.create", "users.edit"];
            return routes.includes(this.$route.name);
        }
    }
};
</script>
