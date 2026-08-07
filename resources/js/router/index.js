import { createRouter, createWebHistory } from 'vue-router';
import Home from '../Pages/Home.vue';
import BlogIndex from '../Pages/BlogIndex.vue';
import BlogPost from '../Pages/BlogPost.vue';
import Login from '../Pages/Admin/Login.vue';
import DashboardHome from '../Pages/Admin/DashboardHome.vue';
import SettingsManager from '../Pages/Admin/SettingsManager.vue';
import ProductsManager from '../Pages/Admin/ProductsManager.vue';
import PostsManager from '../Pages/Admin/PostsManager.vue';
import PartnersManager from '../Pages/Admin/PartnersManager.vue';

const routes = [
  // Rotas Públicas
  { path: '/', name: 'home', component: Home },
  { path: '/blog', name: 'blog.index', component: BlogIndex },
  { path: '/blog/:slug', name: 'blog.show', component: BlogPost },

  // Rotas Admin
  { path: '/admin/login', name: 'admin.login', component: Login },
  { 
    path: '/admin', 
    name: 'admin.dashboard', 
    component: DashboardHome,
    beforeEnter: (to, from, next) => {
      const token = localStorage.getItem('admin_token');
      if (!token) next({ name: 'admin.login' });
      else next();
    }
  },
  { 
    path: '/admin/settings', 
    name: 'admin.settings', 
    component: SettingsManager,
    beforeEnter: (to, from, next) => {
      const token = localStorage.getItem('admin_token');
      if (!token) next({ name: 'admin.login' });
      else next();
    }
  },
  { 
    path: '/admin/products', 
    name: 'admin.products', 
    component: ProductsManager,
    beforeEnter: (to, from, next) => {
      const token = localStorage.getItem('admin_token');
      if (!token) next({ name: 'admin.login' });
      else next();
    }
  },
  { 
    path: '/admin/posts', 
    name: 'admin.posts', 
    component: PostsManager,
    beforeEnter: (to, from, next) => {
      const token = localStorage.getItem('admin_token');
      if (!token) next({ name: 'admin.login' });
      else next();
    }
  },
  { 
    path: '/admin/partners', 
    name: 'admin.partners', 
    component: PartnersManager,
    beforeEnter: (to, from, next) => {
      const token = localStorage.getItem('admin_token');
      if (!token) next({ name: 'admin.login' });
      else next();
    }
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior() {
    return { top: 0 };
  }
});

export default router;
