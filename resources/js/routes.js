import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/pages/Home.vue';
import Dashboard from '../views/AdminPanel/homeDashboard.vue';
import Login from '../views/AdminPanel/loginPage.vue';

const routes = [
  {
    path: '/',
    component: Home
  },
  {
    path: '/admin-panel/login',
    component: Login
  },
  {
    path: '/admin-panel',
    component: Dashboard,
    children: [
      {
        path: '', 
        component: () => import('../views/AdminPanel/dashboardPage.vue')
      },
      {
        path: '/admin-panel/user-setting', 
        component: () => import('../views/AdminPanel/UserSetting.vue')
      }
    ]
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
