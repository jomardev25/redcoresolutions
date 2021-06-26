import Vue from "vue";
import VueRouter from "vue-router";
Vue.use(VueRouter);

const routes = [
    {
        path: "/",
        component: () => import("@/views/layout/Layout"),
        children: [
            {
                path: "/",
                name: "home.index",
                meta: {
                    title: "Home",
                    breadcrumbTitle: "Home",
                    affix: true
                },
                component: () => import("@/views/Home/Index")
            },
            {
                path: "/users",
                name: "users.index",
                meta: {
                    title: "Users",
                    breadcrumbTitle: "Users"
                },
                component: () => import("@/views/user/Index")
            },
            {
                path: "/users/create",
                name: "users.create",
                meta: {
                    title: "Create User",
                    breadcrumbTitle: "Create User"
                },
                component: () => import("@/views/user/Create")
            },
            {
                path: "/users/edit/:id",
                name: "users.edit",
                meta: {
                    title: "Edit User",
                    breadcrumbTitle: "User"
                },
                component: () => import("@/views/user/Edit")
            },
            {
                path: "/users/:id",
                name: "users.show",
                meta: {
                    title: "Show User",
                    breadcrumbTitle: "User"
                },
                component: () => import("@/views/user/Show")
            },
            {
                path: "/roles",
                name: "roles.index",
                meta: {
                    title: "Roles",
                    breadcrumbTitle: "Roles"
                },
                component: () => import("@/views/role/Index")
            },
            {
                path: "/roles/create",
                name: "roles.create",
                meta: {
                    title: "Create Role",
                    breadcrumbTitle: "Create Role"
                },
                component: () => import("@/views/role/Create")
            },
            {
                path: "/roles/:id",
                name: "roles.show",
                meta: {
                    title: "Show Role",
                    breadcrumbTitle: "Roles"
                },
                component: () => import("@/views/role/Show")
            },
            {
                path: "/roles/edit/:id",
                name: "roles.edit",
                meta: {
                    title: "Edit Role",
                    breadcrumbTitle: "Roles"
                },
                component: () => import("@/views/role/Edit")
            }
        ]
    },
    {
        path: "/login",
        name: "login.index",
        meta: {
            title: "Login"
        },
        component: () => import("@/views/auth/Login")
    },
    {
        path: "*",
        name: "pageNotFound",
        component: () => import("@/views/errors/404"),
        meta: { title: "404 Page Not Found" }
    }
];

const createRouter = () =>
    new VueRouter({
        mode: "history",
        linkActiveClass: "active",
        linkExactActiveClass: "active",
        routes: routes,
        base: "/",
        scrollBehavior: () => ({
            y: 0
        })
    });

const router = createRouter();

export default router;
