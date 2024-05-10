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
      },   {
        path: '/admin-panel/add-user', 
        component: () => import('../views/AdminPanel/addUser.vue')
      },
      {
        path: '/admin-panel/add-videos', 
        component: () => import('../views/AdminPanel/addVideos.vue')
      },   {
        path: '/admin-panel/user-list', 
        component: () => import('../views/AdminPanel/userList.vue')
      },
      {
        path: '/admin-panel/videos-list', 
        component: () => import('../views/AdminPanel/videosList.vue')
      },  {
        path: '/admin-panel/search', 
        component: () => import('../views/AdminPanel/Search.vue')
      }
    ]
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
