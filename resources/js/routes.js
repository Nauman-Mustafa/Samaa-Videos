// router/index.js
import { createRouter, createWebHistory } from "vue-router";
import store from "../../src/store";
import Dashboard from "../views/AdminPanel/homeDashboard.vue";
import Login from "../views/AdminPanel/loginPage.vue";
import NotFound from "../views/AdminPanel/NotFound.vue";

const routes = [
    {
        path: "/",
        component: Dashboard,
        meta: { requiresAuth: true },
        children: [
            {
                path: "",
                component: () =>
                    import("../views/AdminPanel/dashboardPage.vue"),
            },
            {
                path: "add-user",
                component: () => import("../views/AdminPanel/addUser.vue"),
            },
            {
                path: "edit-user/:id",
                component: () => import("../views/AdminPanel/addUser.vue"),
            },
            {
                path: "user-list",
                component: () => import("../views/AdminPanel/userList.vue"),
            },
            {
                path: "search",
                component: () => import("../views/AdminPanel/Search.vue"),
            },
            {
                path: "add-category",
                component: () =>
                    import("../views/AdminPanel/addCategories.vue"),
            },
            {
                path: "edit-category/:id",
                component: () =>
                    import("../views/AdminPanel/addCategories.vue"),
            },
            {
                path: "category-list",
                component: () => import("../views/AdminPanel/categoryList.vue"),
            },
            {
                path: "add-asset",
                component: () =>
                    import("../views/AdminPanel/Asset/AddAsset.vue"),
            },
            {
                path: "edit-asset/:id",
                component: () =>
                    import("../views/AdminPanel/Asset/AddAsset.vue"),
            },
            {
                path: "asset-list",
                component: () =>
                    import("../views/AdminPanel/Asset/AssetList.vue"),
            },
            {
                path: "import-assets",
                component: () =>
                    import("../views/AdminPanel/Asset/ImportAssets.vue"),
            },
            {
                path: "organizations",
                component: () =>
                    import(
                        "../views/AdminPanel/Organization/OrganizationList.vue"
                    ),
            },
        ],
    },
    {
        path: "/login",
        component: Login,
        meta: { guest: true },
    },
    {
        path: "/:pathMatch(.*)*",
        component: NotFound,
        meta: { requiresAuth: true },
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    if (to.matched.some((record) => record.meta.requiresAuth)) {
        if (!store.getters.isAuthenticated) {
            next({
                path: "/login",
                query: { redirect: to.fullPath },
            });
        } else {
            next();
        }
    } else if (to.matched.some((record) => record.meta.guest)) {
        if (store.getters.isAuthenticated) {
            next({ path: "/" });
        } else {
            next();
        }
    } else {
        next();
    }
});

export default router;
