<template>
  <section class="py-24 sm:py-28 bg-slate-50">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
      <div v-reveal class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-4">
        <div>
          <div class="flex items-center gap-3 mb-4">
            <div class="h-0.5 w-8 bg-coopesq-orange"></div>
            <span class="text-xs font-bold text-coopesq-orange uppercase tracking-widest">Blog & Notícias</span>
          </div>
          <h2 class="font-display text-3xl sm:text-4xl font-bold text-slate-900">
            Últimas Publicações
          </h2>
        </div>
        <router-link to="/blog" class="group flex items-center gap-2 font-bold text-coopesq-green hover:text-coopesq-orange transition-colors text-sm">
          Ver todas as matérias
          <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </router-link>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div 
          v-for="(post, i) in posts" 
          :key="post.id" 
          v-reveal
          :class="`delay-${(i + 1) * 150}`"
          class="reveal-scale group bg-white rounded-3xl overflow-hidden border border-slate-200/80 card-lift"
        >
          <div class="h-48 bg-gradient-to-br from-coopesq-green to-coopesq-green-mid flex items-center justify-center text-4xl relative overflow-hidden">
            📰
            <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
            <div class="absolute bottom-4 left-4">
              <span class="bg-coopesq-orange text-slate-900 text-xs font-bold px-2.5 py-1 rounded-full">
                {{ post.category ? post.category.name : 'Informativo' }}
              </span>
            </div>
          </div>
          <div class="p-7">
            <h3 class="font-bold text-slate-900 text-lg mb-3 line-clamp-2 group-hover:text-coopesq-green transition-colors leading-snug">
              {{ post.title }}
            </h3>
            <p class="text-slate-500 text-xs line-clamp-3 mb-6 leading-relaxed">
              {{ post.excerpt }}
            </p>
            <router-link :to="`/blog/${post.slug}`" class="group/link flex items-center gap-2 font-bold text-coopesq-green text-xs hover:text-coopesq-orange transition-colors">
              Ler matéria completa
              <svg class="w-3.5 h-3.5 group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
defineProps({
  posts: { type: Array, default: () => [] },
});
</script>
