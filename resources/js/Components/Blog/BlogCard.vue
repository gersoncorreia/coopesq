<template>
  <article class="group bg-white rounded-2xl overflow-hidden border border-slate-200/80 shadow-xs hover:shadow-xl hover:border-[#1B5E20]/50 transition-all duration-300 card-lift flex flex-col justify-between">
    <div>
      <!-- Thumbnail Image -->
      <div class="h-52 bg-slate-100 relative overflow-hidden">
        <img 
          v-if="post.featured_image" 
          :src="post.featured_image" 
          :alt="post.title" 
          class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
          @error="(e) => e.target.style.display = 'none'"
        />
        <div v-else class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-emerald-950/10 via-emerald-800/5 to-slate-100 text-slate-400">
          <span class="text-3xl mb-1">📰</span>
          <span class="text-[11px] font-semibold tracking-wider text-slate-400 uppercase">COOPESQ Notícias</span>
        </div>

        <!-- Category Badge -->
        <div class="absolute top-3 left-3">
          <span class="bg-[#1B5E20] text-white text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-md shadow-md">
            {{ post.category ? post.category.name : 'Informativo' }}
          </span>
        </div>
      </div>

      <!-- Content -->
      <div class="p-6">
        <!-- Metadata: Date and Views -->
        <div class="flex items-center gap-3 text-[11px] font-medium text-slate-400 mb-2.5">
          <span>📅 {{ formatDate(post.published_at || post.created_at) }}</span>
          <span v-if="post.views">• 👁️ {{ post.views }} visualizações</span>
        </div>

        <!-- Title -->
        <h2 class="font-display font-bold text-slate-900 text-lg sm:text-xl leading-snug mb-3 line-clamp-2 group-hover:text-[#1B5E20] transition-colors">
          <router-link :to="`/blog/${post.slug}`">
            {{ post.title }}
          </router-link>
        </h2>

        <!-- Excerpt -->
        <p class="text-slate-600 text-xs sm:text-sm leading-relaxed line-clamp-3 font-normal">
          {{ post.excerpt || 'Clique no artigo para conferir a notícia completa publicada pela cooperativa.' }}
        </p>
      </div>
    </div>

    <!-- Card Footer / Link -->
    <div class="p-6 pt-0">
      <router-link 
        :to="`/blog/${post.slug}`" 
        class="inline-flex items-center gap-2 font-bold text-[#1B5E20] text-xs uppercase tracking-wider group-hover:text-[#F5A623] transition-colors"
      >
        <span>Ler matéria completa</span>
        <svg class="w-4 h-4 group-hover:translate-x-1.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
        </svg>
      </router-link>
    </div>
  </article>
</template>

<script setup>
defineProps({
  post: { type: Object, required: true },
});

const formatDate = (dateStr) => {
  if (!dateStr) return 'Recente';
  const d = new Date(dateStr);
  return d.toLocaleDateString('pt-BR', { day: '2-digit', month: 'short', year: 'numeric' });
};
</script>
