// router/index.js
import { createRouter, createWebHistory } from 'vue-router';
import store from '../../src/store';
import Home from '../views/pages/Home.vue';
import HomePage from '../views/pages/MainPage.vue';

import Dashboard from '../views/AdminPanel/homeDashboard.vue';
import Login from '../views/AdminPanel/loginPage.vue';

const routes = [
    {
        path: '/',
        component: Home,
        children: [
            {
                path: '',
                component: HomePage
            },
         
        ]
    },
    {
        path: '/admin-panel/login',
        component: Login,
        meta: { guest: true }
    },
    {
        path: '/admin-panel',
        component: Dashboard,
        meta: { requiresAuth: true },
        children: [
            {
                path: '',
                component: () => import('../views/AdminPanel/dashboardPage.vue')
            },
            {
                path: 'add-user',
                component: () => import('../views/AdminPanel/addUser.vue')
            },
            {
                path: 'edit-user/:id',
                component: () => import('../views/AdminPanel/addUser.vue')
            },
            {
                path: 'add-videos',
                component: () => import('../views/AdminPanel/addVideos.vue')
            },
            {
                path: 'user-list',
                component: () => import('../views/AdminPanel/userList.vue')
            },
            {
                path: 'videos-list',
                component: () => import('../views/AdminPanel/videosList.vue')
            },
            {
                path: 'search',
                component: () => import('../views/AdminPanel/Search.vue')
            },
            {
                path: 'add-category',
                component: () => import('../views/AdminPanel/addCategories.vue')
            },
            {
                path: 'edit-category/:id',
                component: () => import('../views/AdminPanel/addCategories.vue')
            },
            {
                path: 'category-list',
                component: () => import('../views/AdminPanel/categoryList.vue')
            }
        ]
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!store.getters.isAuthenticated) {
            next({
                path: '/admin-panel/login',
                query: { redirect: to.fullPath }
            });
        } else {
            next();
        }
    } else if (to.matched.some(record => record.meta.guest)) {
        if (store.getters.isAuthenticated) {
            next({ path: '/admin-panel' });
        } else {
            next();
        }
    } else {
        next();
    }
});

export default router;
