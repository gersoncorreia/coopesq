<template>
  <div class="bg-slate-50 min-h-screen">
    <!-- Hero Header with Breadcrumbs and Post Title -->
    <BlogHero 
      :is-article="true"
      :breadcrumb-title="post.title"
      :badge="post.category ? post.category.name : 'INFORMATIVO COOPESQ'"
      :title="post.title"
      :subtitle="''"
    />

    <!-- Article Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-8 py-8 sm:py-14">
      <div v-if="loading" class="bg-white rounded-2xl sm:rounded-3xl p-6 sm:p-12 shadow-sm border border-slate-200 animate-pulse">
        <div class="h-6 bg-slate-200 rounded w-1/4 mb-4"></div>
        <div class="h-64 bg-slate-200 rounded-2xl mb-8"></div>
        <div class="space-y-4">
          <div class="h-4 bg-slate-200 rounded w-full"></div>
          <div class="h-4 bg-slate-200 rounded w-5/6"></div>
          <div class="h-4 bg-slate-200 rounded w-4/6"></div>
        </div>
      </div>

      <article v-else-if="post.id" class="bg-white rounded-2xl sm:rounded-3xl p-5 sm:p-12 shadow-sm border border-slate-200 overflow-hidden">
        <!-- Article Meta Details -->
        <div class="flex flex-wrap items-center gap-4 text-xs font-semibold text-slate-400 pb-6 border-b border-slate-100 mb-8">
          <span class="flex items-center gap-1.5">
            📅 {{ formatDate(post.published_at || post.created_at) }}
          </span>
          <span>•</span>
          <span class="flex items-center gap-1.5">
            ✍️ {{ post.author ? post.author.name : 'Assessoria COOPESQ' }}
          </span>
          <span v-if="post.views">•</span>
          <span v-if="post.views" class="flex items-center gap-1.5">
            👁️ {{ post.views }} visualizações
          </span>
        </div>

        <!-- Featured Image -->
        <div v-if="post.featured_image" class="mb-8 rounded-2xl overflow-hidden shadow-sm max-h-[480px]">
          <img 
            :src="post.featured_image" 
            :alt="post.title" 
            class="w-full h-full object-cover max-h-[480px]"
            @error="(e) => e.target.style.display = 'none'"
          />
        </div>

        <!-- HTML Body -->
        <div 
          class="prose prose-emerald max-w-none text-slate-700 leading-relaxed text-sm sm:text-base space-y-4 break-words overflow-hidden" 
          v-html="post.content"
        ></div>

        <!-- Bottom Action Bar -->
        <div class="mt-12 pt-8 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
          <router-link 
            to="/blog" 
            class="inline-flex items-center gap-2 text-xs font-bold text-[#1B5E20] hover:text-[#d48b16] transition-colors"
          >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/></svg>
            <span>Voltar para todas as notícias</span>
          </router-link>

          <a 
            :href="`https://api.whatsapp.com/send?text=${encodeURIComponent(shareText)}`" 
            target="_blank"
            class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-50 hover:bg-emerald-100 text-[#1B5E20] text-xs font-bold rounded-xl transition-all border border-emerald-200"
          >
            <span>Compartilhar no WhatsApp</span>
          </a>
        </div>
      </article>
    </main>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import axios from 'axios';
import BlogHero from '../Components/Blog/BlogHero.vue';

const route = useRoute();
const post = ref({});
const loading = ref(true);

const formatDate = (dateStr) => {
  if (!dateStr) return '';
  const d = new Date(dateStr);
  return d.toLocaleDateString('pt-BR', { day: '2-digit', month: 'long', year: 'numeric' });
};

const shareText = computed(() => {
  return `${post.value.title || 'Notícia COOPESQ'} - Leia mais em: ${window.location.href}`;
});

const loadPost = async () => {
  loading.value = true;
  try {
    const res = await axios.get(`/api/posts/${route.params.slug}`);
    post.value = res.data;
  } catch (err) {
    console.error('Erro ao carregar post:', err);
  } finally {
    loading.value = false;
  }
};

onMounted(() => {
  loadPost();
});
</script>
