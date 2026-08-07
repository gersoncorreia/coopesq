<template>
  <section id="diferenciais" class="py-24 sm:py-28 bg-coopesq-dark relative overflow-hidden">
    <div class="absolute top-0 left-1/2 w-[800px] h-[600px] bg-coopesq-green/10 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
    
    <div class="relative max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
      <!-- Header -->
      <div v-reveal class="text-center max-w-2xl mx-auto mb-16 sm:mb-20">
        <div class="flex items-center justify-center gap-3 mb-4">
          <div class="h-0.5 w-8 bg-coopesq-orange"></div>
          <span class="text-xs font-bold text-coopesq-orange uppercase tracking-widest">Nossos Diferenciais</span>
          <div class="h-0.5 w-8 bg-coopesq-orange"></div>
        </div>
        <h2 class="font-display text-3xl sm:text-5xl font-bold text-white leading-tight">
          Por que escolher a <span class="gradient-text">COOPESQ</span>?
        </h2>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div 
          v-for="(diff, i) in differentials" 
          :key="diff.id"
          v-reveal
          :class="`delay-${(i + 1) * 100}`"
          class="reveal-scale group relative glass rounded-3xl p-7 hover:bg-white/10 transition-all duration-300 card-lift cursor-default"
        >
          <div class="text-coopesq-orange/20 font-display font-bold text-6xl absolute top-4 right-5 leading-none select-none">
            {{ String(i + 1).padStart(2, '0') }}
          </div>
          <div class="relative w-12 h-12 bg-coopesq-orange/20 border border-coopesq-orange/30 rounded-2xl flex items-center justify-center text-xl mb-6 group-hover:bg-coopesq-orange/30 transition-colors">
            {{ getDiffIcon(diff.title) }}
          </div>
          <h3 class="text-white font-bold text-lg mb-3">{{ diff.title }}</h3>
          <p class="text-white/50 text-sm leading-relaxed">{{ diff.description }}</p>
          <div class="mt-6 h-0.5 bg-gradient-to-r from-coopesq-orange/60 to-transparent rounded-full"></div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { getDiffIcon } from '../../utils/iconHelpers';

defineProps({
  differentials: { type: Array, default: () => [] },
});
</script>
