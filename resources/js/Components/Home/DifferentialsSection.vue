<template>
  <section id="diferenciais" class="py-24 sm:py-32 bg-slate-50 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 relative z-10">
      <!-- Header no padrão Khela -->
      <div v-reveal class="text-center max-w-3xl mx-auto mb-16 sm:mb-20">
        <span class="text-xs font-bold text-[#F5A623] uppercase tracking-[0.25em] block mb-2">
          Our Best Services • Nossos Diferenciais
        </span>
        <h2 class="font-display text-3xl sm:text-4xl font-extrabold text-slate-900 uppercase tracking-tight">
          POR QUE ESCOLHER A <span class="text-[#1B5E20]">COOPESQ</span>
        </h2>
        <div class="w-12 h-1 bg-[#1B5E20] mx-auto mt-4 rounded-full"></div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div 
          v-for="(diff, i) in differentials" 
          :key="diff.id" 
          v-reveal
          :class="`delay-${(i + 1) * 100}`"
          class="reveal-scale group bg-white rounded-xl p-7 border border-slate-200/80 hover:border-[#1B5E20]/40 shadow-xs hover:shadow-xl transition-all duration-300 card-lift"
        >
          <div class="w-13 h-13 rounded-lg bg-emerald-50 border border-emerald-100 flex items-center justify-center text-2xl mb-5 group-hover:bg-[#1B5E20] group-hover:text-white transition-colors">
            {{ getDiffIcon(diff.title) }}
          </div>
          <h3 class="text-slate-900 font-bold text-base mb-2 group-hover:text-[#1B5E20] transition-colors leading-snug">
            {{ diff.title }}
          </h3>
          <p class="text-slate-500 text-xs leading-relaxed">
            {{ diff.description }}
          </p>
          <div class="mt-5 w-8 h-0.5 bg-[#F5A623] group-hover:w-full transition-all duration-300 rounded-full"></div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { getDiffIcon } from '../../utils/iconHelpers';

defineProps({
  differentials: { type: [Array, Object], default: () => [] },
});
</script>
