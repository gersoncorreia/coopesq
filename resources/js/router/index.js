import { createRouter, createWebHistory } from 'vue-router';
import Home from '../Pages/Home.vue';
import BlogIndex from '../Pages/BlogIndex.vue';
import BlogPost from '../Pages/BlogPost.vue';
import Login from '../Pages/Admin/Login.vue';
import DashboardHome from '../Pages/Admin/DashboardHome.vue';
import SettingsManager from '../Pages/Admin/SettingsManager.vue';
import BannersManager from '../Pages/Admin/BannersManager.vue';
import ProductsManager from '../Pages/Admin/ProductsManager.vue';
import PostsManager from '../Pages/Admin/PostsManager.vue';
import TestimonialsManager from '../Pages/Admin/TestimonialsManager.vue';
import PartnersManager from '../Pages/Admin/PartnersManager.vue';
import PagesManager from '../Pages/Admin/PagesManager.vue';
import UsersManager from '../Pages/Admin/UsersManager.vue';

const requireAuth = (to, from, next) => {
  const token = localStorage.getItem('admin_token');
  if (!token) next({ name: 'admin.login' });
  else next();
};

const routes = [
  // Rotas Públicas
  { path: '/', name: 'home', component: Home },
  { path: '/blog', name: 'blog.index', component: BlogIndex },
  { path: '/blog/:slug', name: 'blog.show', component: BlogPost },

  // Rotas Admin
  { path: '/admin/login', name: 'admin.login', component: Login },
  { path: '/admin', name: 'admin.dashboard', component: DashboardHome, beforeEnter: requireAuth },
  { path: '/admin/settings', name: 'admin.settings', component: SettingsManager, beforeEnter: requireAuth },
  { path: '/admin/banners', name: 'admin.banners', component: BannersManager, beforeEnter: requireAuth },
  { path: '/admin/products', name: 'admin.products', component: ProductsManager, beforeEnter: requireAuth },
  { path: '/admin/posts', name: 'admin.posts', component: PostsManager, beforeEnter: requireAuth },
  { path: '/admin/testimonials', name: 'admin.testimonials', component: TestimonialsManager, beforeEnter: requireAuth },
  { path: '/admin/partners', name: 'admin.partners', component: PartnersManager, beforeEnter: requireAuth },
  { path: '/admin/pages', name: 'admin.pages', component: PagesManager, beforeEnter: requireAuth },
  { path: '/admin/users', name: 'admin.users', component: UsersManager, beforeEnter: requireAuth },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition;
    }
    if (to.hash) {
      return {
        el: to.hash,
        behavior: 'smooth',
      };
    }
    return { top: 0 };
  }
});

export default router;
