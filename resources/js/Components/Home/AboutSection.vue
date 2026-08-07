<template>
  <section id="sobre" class="py-24 sm:py-28 bg-white">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
      <!-- Section header -->
      <div v-reveal class="max-w-2xl mb-16 sm:mb-20">
        <div class="flex items-center gap-3 mb-4">
          <div class="h-0.5 w-8 bg-coopesq-orange"></div>
          <span class="text-xs font-bold text-coopesq-orange uppercase tracking-widest">Nossa Cooperativa</span>
        </div>
        <h2 class="font-display text-3xl sm:text-5xl font-bold text-slate-900 leading-tight">
          Uma cooperativa que <em class="not-italic text-coopesq-green">cuida da terra</em> e das pessoas
        </h2>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
        <!-- Missão -->
        <div v-reveal class="reveal-scale delay-100 relative bg-gradient-to-br from-coopesq-green to-coopesq-green-mid p-8 rounded-3xl overflow-hidden group card-lift">
          <div class="absolute top-0 right-0 w-40 h-40 bg-white/5 rounded-full -translate-y-12 translate-x-12"></div>
          <div class="absolute bottom-0 left-0 w-24 h-24 bg-coopesq-orange/10 rounded-full translate-y-8 -translate-x-8"></div>
          <div class="relative">
            <div class="w-14 h-14 bg-coopesq-orange/20 rounded-2xl flex items-center justify-center text-2xl mb-6 border border-coopesq-orange/20">🎯</div>
            <h3 class="text-xl font-bold text-white mb-4">Nossa Missão</h3>
            <p class="text-emerald-100/80 text-sm leading-relaxed">
              {{ settings.mission || 'Promover o desenvolvimento sustentável da agricultura e piscicultura.' }}
            </p>
          </div>
        </div>

        <!-- Visão -->
        <div v-reveal class="reveal-scale delay-200 relative bg-gradient-to-br from-coopesq-green-pale to-emerald-50 border border-emerald-100 p-8 rounded-3xl overflow-hidden group card-lift">
          <div class="absolute top-0 right-0 w-40 h-40 bg-coopesq-green/5 rounded-full -translate-y-12 translate-x-12"></div>
          <div class="relative">
            <div class="w-14 h-14 bg-coopesq-green/10 rounded-2xl flex items-center justify-center text-2xl mb-6 border border-coopesq-green/15">🌿</div>
            <h3 class="text-xl font-bold text-slate-900 mb-4">Nossa Visão</h3>
            <p class="text-slate-600 text-sm leading-relaxed">
              {{ settings.vision || 'Ser referência mundial em produção de piscicultura e produtos amazônicos.' }}
            </p>
          </div>
        </div>

        <!-- Valores -->
        <div v-reveal class="reveal-scale delay-300 relative bg-gradient-to-br from-amber-50 to-orange-50 border border-amber-100 p-8 rounded-3xl overflow-hidden group card-lift">
          <div class="absolute bottom-0 right-0 w-32 h-32 bg-coopesq-orange/8 rounded-full translate-y-8 translate-x-8"></div>
          <div class="relative">
            <div class="w-14 h-14 bg-coopesq-orange/15 rounded-2xl flex items-center justify-center text-2xl mb-6 border border-coopesq-orange/20">💎</div>
            <h3 class="text-xl font-bold text-slate-900 mb-4">Nossos Valores</h3>
            <p class="text-slate-600 text-sm leading-relaxed">
              {{ settings.values || 'Compromisso, Ética, Transparência, Responsabilidade e Solidariedade.' }}
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
defineProps({
  settings: { type: Object, default: () => ({}) },
});
</script>
