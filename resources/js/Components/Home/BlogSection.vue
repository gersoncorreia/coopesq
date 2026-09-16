<template>
  <section class="py-24 sm:py-32 bg-white">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
      <!-- Header no padrão Khela -->
      <div v-reveal class="text-center max-w-3xl mx-auto mb-16 sm:mb-20">
        <span class="text-xs font-bold text-[#F5A623] uppercase tracking-[0.25em] block mb-2">
          Latest News • Nosso Blog
        </span>
        <h2 class="font-display text-3xl sm:text-4xl font-extrabold text-slate-900 uppercase tracking-tight">
          NOTÍCIAS & <span class="text-[#1B5E20]">PUBLICATIVAS</span>
        </h2>
        <div class="w-12 h-1 bg-[#1B5E20] mx-auto mt-4 rounded-full"></div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div 
          v-for="(post, i) in posts" 
          :key="post.id" 
          v-reveal
          :class="`delay-${(i + 1) * 150}`"
          class="reveal-scale group bg-white rounded-xl overflow-hidden border border-slate-200 shadow-xs hover:shadow-xl hover:border-[#1B5E20]/40 transition-all duration-300 card-lift flex flex-col justify-between"
        >
          <div>
            <div class="h-48 bg-slate-100 flex items-center justify-center text-4xl relative overflow-hidden">
              <img 
                v-if="post.featured_image" 
                :src="post.featured_image" 
                :alt="post.title" 
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                @error="(e) => e.target.style.display = 'none'"
              />
              <span v-if="!post.featured_image">📰</span>
              <div class="absolute top-3 left-3">
                <span class="bg-[#1B5E20] text-white text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded shadow-xs">
                  {{ post.category ? post.category.name : 'Informativo' }}
                </span>
              </div>
            </div>
            <div class="p-6">
              <h3 class="font-bold text-slate-900 text-base mb-2 line-clamp-2 group-hover:text-[#1B5E20] transition-colors leading-snug">
                {{ post.title }}
              </h3>
              <p class="text-slate-500 text-xs line-clamp-3 leading-relaxed">
                {{ post.excerpt }}
              </p>
            </div>
          </div>
          <div class="p-6 pt-0">
            <router-link :to="`/blog/${post.slug}`" class="inline-flex items-center gap-1.5 font-bold text-[#1B5E20] text-xs uppercase tracking-wider hover:text-[#d48b16] transition-colors">
              <span>Ler Matéria</span>
              <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
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
