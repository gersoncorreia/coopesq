<template>
  <div class="min-h-screen bg-slate-100 py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
      <router-link to="/blog" class="inline-flex items-center text-xs font-bold text-coopesq-green hover:underline mb-8">
        ← Voltar para Notícias
      </router-link>

      <article v-if="post.id" class="bg-white rounded-3xl p-8 sm:p-12 shadow-sm border border-slate-200">
        <span class="text-xs font-bold text-coopesq-orange uppercase tracking-wider block mb-3">
          {{ post.category ? post.category.name : 'Informativo' }}
        </span>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 leading-tight mb-6">
          {{ post.title }}
        </h1>
        <div class="flex items-center space-x-4 text-xs text-slate-400 pb-8 border-b border-slate-100 mb-8">
          <span>📅 {{ new Date(post.created_at).toLocaleDateString('pt-BR') }}</span>
          <span>✍️ {{ post.author ? post.author.name : 'COOPESQ' }}</span>
          <span>👁️ {{ post.views || 0 }} visualizações</span>
        </div>
        <div class="prose max-w-none text-slate-700 leading-relaxed space-y-4" v-html="post.content"></div>
      </article>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import axios from 'axios';

const route = useRoute();
const post = ref({});

const loadPost = async () => {
  try {
    const res = await axios.get(`/api/posts/${route.params.slug}`);
    post.value = res.data;
  } catch (err) {
    console.error('Erro ao carregar post:', err);
  }
};

onMounted(() => {
  loadPost();
});
</script>
