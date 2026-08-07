<template>
  <section id="parceiros" class="py-24 bg-white border-y border-slate-100">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
      <div v-reveal class="text-center mb-14">
        <div class="flex items-center justify-center gap-3 mb-4">
          <div class="h-0.5 w-8 bg-coopesq-orange"></div>
          <span class="text-xs font-bold text-coopesq-orange uppercase tracking-widest">Quem Atendemos</span>
          <div class="h-0.5 w-8 bg-coopesq-orange"></div>
        </div>
        <h2 class="font-display text-3xl sm:text-4xl font-bold text-slate-900">
          Parceiros e Clientes Institucionais
        </h2>
        <p class="text-slate-500 text-sm mt-3 max-w-md mx-auto">Atendemos prefeituras, universidades, restaurantes e distribuidores com produtos de alta qualidade.</p>
      </div>

      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
        <div 
          v-for="(partner, i) in partners" 
          :key="partner.id" 
          v-reveal
          :class="`delay-${(i % 6 + 1) * 100}`"
          class="reveal-scale group bg-slate-50 hover:bg-coopesq-green-pale border border-slate-200 hover:border-coopesq-green/30 rounded-2xl p-5 flex flex-col items-center justify-center gap-3 transition-all duration-300 card-lift cursor-default"
        >
          <div class="w-12 h-12 rounded-2xl bg-coopesq-green/10 group-hover:bg-coopesq-green/20 flex items-center justify-center text-2xl transition-colors">
            🏛️
          </div>
          <span class="text-xs font-semibold text-slate-700 text-center line-clamp-2 leading-snug">{{ partner.name }}</span>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
defineProps({
  partners: { type: Array, default: () => [] },
});
</script>
