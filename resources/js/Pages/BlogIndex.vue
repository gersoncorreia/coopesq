<template>
  <div class="bg-slate-50 min-h-screen">
    <!-- Blog Hero Banner -->
    <BlogHero 
      :show-search="true" 
      @search="handleSearch" 
    />

    <!-- Main Content Area -->
    <main class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-12 py-10 sm:py-16">
      <!-- Search/Filter Status Bar -->
      <div v-if="searchQuery" class="flex items-center justify-between bg-white p-4 rounded-2xl border border-slate-200 shadow-xs mb-8">
        <div class="text-xs sm:text-sm text-slate-600">
          Resultados da busca para: <strong class="text-slate-900 font-bold">"{{ searchQuery }}"</strong>
          <span class="text-slate-400 ml-1">({{ pagination.total || posts.length }} encontrados)</span>
        </div>
        <button 
          @click="clearSearch" 
          class="text-xs font-bold text-[#1B5E20] hover:text-[#d48b16] underline cursor-pointer"
        >
          Limpar busca
        </button>
      </div>

      <!-- Loading Skeleton -->
      <div v-if="loading" class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div v-for="n in 3" :key="n" class="bg-white rounded-2xl overflow-hidden border border-slate-200 animate-pulse">
          <div class="h-52 bg-slate-200"></div>
          <div class="p-6 space-y-3">
            <div class="h-3 bg-slate-200 rounded w-1/3"></div>
            <div class="h-5 bg-slate-200 rounded w-4/5"></div>
            <div class="h-3 bg-slate-200 rounded w-full"></div>
            <div class="h-3 bg-slate-200 rounded w-2/3"></div>
          </div>
        </div>
      </div>

      <!-- Posts Grid -->
      <div v-else-if="posts.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <BlogCard 
          v-for="post in posts" 
          :key="post.id" 
          :post="post" 
        />
      </div>

      <!-- Empty State -->
      <div v-else class="text-center py-20 bg-white rounded-3xl border border-slate-200 p-8 shadow-xs max-w-xl mx-auto">
        <div class="w-16 h-16 rounded-full bg-emerald-50 text-[#1B5E20] text-2xl flex items-center justify-center mx-auto mb-4">
          🔍
        </div>
        <h3 class="font-display font-bold text-slate-900 text-lg mb-2">Nenhuma publicação encontrada</h3>
        <p class="text-slate-500 text-sm mb-6 max-w-md mx-auto">
          Não encontramos artigos correspondentes ao seu critério de busca. Experimente buscar por outros termos.
        </p>
        <button 
          @click="clearSearch" 
          class="px-6 py-2.5 bg-[#1B5E20] hover:bg-[#154a19] text-white text-xs font-bold uppercase tracking-wider rounded-xl transition-all shadow-md"
        >
          Ver Todas as Notícias
        </button>
      </div>

      <!-- Pagination -->
      <div v-if="!loading && pagination.last_page > 1" class="flex items-center justify-center gap-3 mt-14">
        <button 
          :disabled="pagination.current_page <= 1"
          @click="loadPosts(pagination.current_page - 1)"
          class="px-4 py-2 bg-white border border-slate-200 text-slate-700 hover:border-[#1B5E20] disabled:opacity-40 disabled:cursor-not-allowed rounded-xl text-xs font-bold transition-all shadow-xs"
        >
          ← Anterior
        </button>
        <span class="text-xs font-bold text-slate-600 px-3">
          Página {{ pagination.current_page }} de {{ pagination.last_page }}
        </span>
        <button 
          :disabled="pagination.current_page >= pagination.last_page"
          @click="loadPosts(pagination.current_page + 1)"
          class="px-4 py-2 bg-white border border-slate-200 text-slate-700 hover:border-[#1B5E20] disabled:opacity-40 disabled:cursor-not-allowed rounded-xl text-xs font-bold transition-all shadow-xs"
        >
          Próxima →
        </button>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import BlogHero from '../Components/Blog/BlogHero.vue';
import BlogCard from '../Components/Blog/BlogCard.vue';

const posts = ref([]);
const loading = ref(true);
const searchQuery = ref('');
const pagination = ref({ current_page: 1, last_page: 1, total: 0 });

const loadPosts = async (page = 1) => {
  loading.value = true;
  try {
    let url = `/api/posts?page=${page}`;
    if (searchQuery.value) url += `&search=${encodeURIComponent(searchQuery.value)}`;
    const res = await axios.get(url);
    posts.value = res.data.data || [];
    pagination.value = {
      current_page: res.data.current_page || 1,
      last_page: res.data.last_page || 1,
      total: res.data.total || 0,
    };
  } catch (err) {
    console.error('Erro ao carregar matérias:', err);
  } finally {
    loading.value = false;
  }
};

const handleSearch = (query) => {
  searchQuery.value = query;
  loadPosts(1);
};

const clearSearch = () => {
  searchQuery.value = '';
  loadPosts(1);
};

onMounted(() => {
  loadPosts();
});
</script>
