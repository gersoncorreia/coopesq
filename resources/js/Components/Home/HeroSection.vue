<template>
  <section class="relative min-h-screen flex items-center bg-coopesq-dark overflow-hidden">
    <!-- Background photo -->
    <div class="absolute inset-0">
      <img 
        src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?auto=format&fit=crop&w=1920&q=90" 
        alt="Amazônia - COOPESQ" 
        class="w-full h-full object-cover"
      />
      <div class="absolute inset-0 bg-gradient-to-r from-coopesq-dark via-coopesq-dark/85 to-coopesq-dark/30"></div>
      <div class="absolute inset-0 bg-gradient-to-t from-coopesq-dark/80 via-transparent to-transparent"></div>
    </div>

    <!-- Decorative circles -->
    <div class="absolute top-1/4 right-1/4 w-96 h-96 bg-coopesq-green/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-1/4 right-1/3 w-64 h-64 bg-coopesq-orange/10 rounded-full blur-3xl pointer-events-none"></div>

    <!-- Content -->
    <div class="relative z-10 w-full max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 py-32 pt-40">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">

        <!-- LEFT -->
        <div v-reveal class="reveal-left">
          <div class="inline-flex items-center gap-2 bg-coopesq-orange/20 border border-coopesq-orange/40 text-coopesq-orange font-bold px-4 py-2 rounded-full text-xs uppercase tracking-widest mb-8">
            <span class="w-2 h-2 bg-coopesq-orange rounded-full animate-pulse"></span>
            Cooperativa Amazônica — Porto Acre, AC
          </div>

          <h1 class="font-display text-4xl sm:text-6xl lg:text-7xl font-bold text-white leading-[1.05] tracking-tight mb-6">
            Da Amazônia<br/>
            <span class="gradient-text">para o mundo</span>
          </h1>

          <p class="text-base sm:text-xl text-white/60 leading-relaxed">
            {{ heroBanner.subtitle || 'A COOPESQ une piscicultores e agricultores para levar o melhor da produção amazônica — sustentável, fresca e rastreável — a restaurantes, distribuidores e mercados.' }}
          </p>
        </div>

        <!-- RIGHT -->
        <div v-reveal class="reveal-right flex flex-col justify-center gap-10">
          <div class="flex flex-col sm:flex-row lg:flex-col xl:flex-row gap-4">
            <a 
              href="#produtos" 
              @click.prevent="$emit('scroll-to', 'produtos')"
              class="group flex items-center justify-center gap-3 bg-coopesq-orange hover:bg-amber-400 text-slate-900 font-bold px-7 py-4 rounded-2xl transition-all duration-300 shadow-xl shadow-amber-500/25 hover:shadow-amber-500/40 hover:-translate-y-0.5 text-base"
            >
              Ver Catálogo de Produtos
              <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
            <a 
              href="#sobre"
              @click.prevent="$emit('scroll-to', 'sobre')"
              class="flex items-center justify-center gap-3 glass text-white font-semibold px-7 py-4 rounded-2xl hover:bg-white/15 transition-all duration-300 text-base"
            >
              Conheça a COOPESQ
            </a>
          </div>

          <div class="h-px bg-white/10"></div>

          <div class="grid grid-cols-3 gap-4 sm:gap-6">
            <div class="text-white">
              <div class="font-display text-3xl sm:text-4xl font-bold text-coopesq-orange leading-none">14+</div>
              <div class="text-[11px] sm:text-xs text-white/45 font-medium uppercase tracking-wider mt-2 leading-snug">Produtos Cadastrados</div>
            </div>
            <div class="text-white">
              <div class="font-display text-3xl sm:text-4xl font-bold text-coopesq-orange leading-none">12+</div>
              <div class="text-[11px] sm:text-xs text-white/45 font-medium uppercase tracking-wider mt-2 leading-snug">Parceiros Atendidos</div>
            </div>
            <div class="text-white">
              <div class="font-display text-3xl sm:text-4xl font-bold text-coopesq-orange leading-none">100%</div>
              <div class="text-[11px] sm:text-xs text-white/45 font-medium uppercase tracking-wider mt-2 leading-snug">Produção Sustentável</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Scroll hint -->
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 scroll-hint">
      <span class="text-white/30 text-xs font-medium tracking-widest uppercase">Scroll</span>
      <div class="w-px h-8 bg-gradient-to-b from-white/30 to-transparent"></div>
    </div>
  </section>
</template>

<script setup>
defineProps({
  heroBanner: { type: Object, default: () => ({}) },
});
defineEmits(['scroll-to']);
</script>
