<template>
  <AdminLayout>
    <div class="space-y-6">
      <!-- Minimalist Header -->
      <DashboardHeader :system-info="stats.system_info" />

      <!-- Minimalist KPI Grid -->
      <MetricsGrid :stats="stats" />

      <!-- Quick Actions -->
      <QuickActions />

      <!-- Content Activity & Status -->
      <RecentContentFeed 
        :products="stats.recent_products" 
        :posts="stats.recent_posts" 
      />
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';
import AdminLayout from '../../Layouts/AdminLayout.vue';
import DashboardHeader from '../../Components/Admin/Dashboard/DashboardHeader.vue';
import MetricsGrid from '../../Components/Admin/Dashboard/MetricsGrid.vue';
import QuickActions from '../../Components/Admin/Dashboard/QuickActions.vue';
import RecentContentFeed from '../../Components/Admin/Dashboard/RecentContentFeed.vue';

const router = useRouter();
const stats = ref({});
const isLoading = ref(true);

const fetchStats = async () => {
  const token = localStorage.getItem('admin_token');
  if (!token) {
    router.push('/admin/login');
    return;
  }

  isLoading.value = true;
  try {
    const res = await axios.get('/api/admin/stats', {
      headers: { Authorization: `Bearer ${token}` }
    });
    stats.value = res.data;
  } catch (err) {
    console.error('Erro ao carregar estatísticas:', err);
    if (err.response?.status === 401) {
      localStorage.removeItem('admin_token');
      router.push('/admin/login');
    }
  } finally {
    isLoading.value = false;
  }
};

onMounted(() => {
  fetchStats();
});
</script>
