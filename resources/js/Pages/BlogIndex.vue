<template>
  <div class="min-h-screen bg-slate-100 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center max-w-3xl mx-auto mb-12">
        <h1 class="text-3xl font-extrabold text-slate-900">Blog e Notícias da COOPESQ</h1>
        <p class="text-slate-600 text-sm mt-2">Acompanhe as últimas publicações, eventos e inovações da piscicultura amazônica.</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div v-for="post in posts" :key="post.id" class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow border border-slate-200">
          <div class="h-44 bg-coopesq-green/10 flex items-center justify-center text-3xl">
            📰
          </div>
          <div class="p-6">
            <span class="text-xs font-bold text-coopesq-orange uppercase tracking-wider block mb-2">
              {{ post.category ? post.category.name : 'Informativo' }}
            </span>
            <h2 class="font-bold text-slate-900 text-lg mb-3 line-clamp-2">
              {{ post.title }}
            </h2>
            <p class="text-slate-600 text-xs line-clamp-3 mb-4 leading-relaxed">
              {{ post.excerpt }}
            </p>
            <router-link :to="`/blog/${post.slug}`" class="font-bold text-coopesq-green text-xs hover:underline">
              Ler matéria completa
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const posts = ref([]);

const loadPosts = async () => {
  try {
    const res = await axios.get('/api/posts');
    posts.value = res.data.data || [];
  } catch (err) {
    console.error('Erro ao carregar matérias:', err);
  }
};

onMounted(() => {
  loadPosts();
});
</script>
