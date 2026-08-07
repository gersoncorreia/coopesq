<template>
  <AdminLayout>
    <div class="space-y-8">
      <div>
        <h1 class="text-2xl font-extrabold text-slate-900">Visão Geral do Sistema</h1>
        <p class="text-xs text-slate-500">Métricas gerais e gerenciamento dinâmico da cooperativa</p>
      </div>

      <!-- Stat Cards -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
          <span class="text-xs font-bold uppercase text-slate-400 tracking-wider">Produtos Cadastrados</span>
          <div class="text-3xl font-black text-coopesq-green mt-2">{{ stats.total_products || 0 }}</div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
          <span class="text-xs font-bold uppercase text-slate-400 tracking-wider">Matérias Publicadas</span>
          <div class="text-3xl font-black text-coopesq-orange mt-2">{{ stats.published_posts || 0 }}</div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
          <span class="text-xs font-bold uppercase text-slate-400 tracking-wider">Parceiros Ativos</span>
          <div class="text-3xl font-black text-slate-800 mt-2">{{ stats.total_partners || 0 }}</div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
          <span class="text-xs font-bold uppercase text-slate-400 tracking-wider">Visualizações do Blog</span>
          <div class="text-3xl font-black text-indigo-600 mt-2">{{ stats.total_post_views || 0 }}</div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';
import AdminLayout from '../../Layouts/AdminLayout.vue';

const router = useRouter();
const stats = ref({});

const fetchStats = async () => {
  const token = localStorage.getItem('admin_token');
  if (!token) {
    router.push('/admin/login');
    return;
  }

  try {
    const res = await axios.get('/api/admin/stats', {
      headers: { Authorization: `Bearer ${token}` }
    });
    stats.value = res.data;
  } catch (err) {
    console.error('Erro ao carregar estatísticas:', err);
    router.push('/admin/login');
  }
};

onMounted(() => {
  fetchStats();
});
</script>
