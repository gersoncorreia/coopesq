<template>
  <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-8 lg:px-12 -mt-8 sm:-mt-14 md:-mt-20">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-0 rounded-xl overflow-hidden shadow-2xl border border-white/10">
      <!-- Box 1 -->
      <div class="feature-box-1 bg-[#144718] p-5 sm:p-7 md:p-8 flex items-start gap-4 sm:gap-5 border-b md:border-b-0 md:border-r border-white/10 group hover:bg-[#18531d] transition-colors">
        <div class="w-13 h-13 rounded-lg bg-white/10 border border-white/15 flex items-center justify-center text-[#F5A623] shrink-0 group-hover:scale-105 transition-transform">
          <Fish :size="26" />
        </div>
        <div>
          <h3 class="text-white font-bold text-base sm:text-lg mb-1.5 tracking-tight">Piscicultura Sustentável</h3>
          <p class="text-emerald-100/70 text-xs leading-relaxed">
            Manejo ético e de alta performance de peixes nativos da bacia amazônica com rastreabilidade total.
          </p>
        </div>
      </div>

      <!-- Box 2 -->
      <div class="feature-box-2 bg-[#18531d] p-5 sm:p-7 md:p-8 flex items-start gap-4 sm:gap-5 border-b md:border-b-0 md:border-r border-white/10 group hover:bg-[#1d6323] transition-colors">
        <div class="w-13 h-13 rounded-lg bg-white/10 border border-white/15 flex items-center justify-center text-[#F5A623] shrink-0 group-hover:scale-105 transition-transform">
          <Truck :size="26" />
        </div>
        <div>
          <h3 class="text-white font-bold text-base sm:text-lg mb-1.5 tracking-tight">Distribuição & Logística</h3>
          <p class="text-emerald-100/70 text-xs leading-relaxed">
            Cadeia de frio rigorosa e entrega garantida para mercados, restaurantes e entidades públicas.
          </p>
        </div>
      </div>

      <!-- Box 3 -->
      <div class="feature-box-3 bg-[#1d6323] p-5 sm:p-7 md:p-8 flex items-start gap-4 sm:gap-5 group hover:bg-[#227228] transition-colors">
        <div class="w-13 h-13 rounded-lg bg-white/10 border border-white/15 flex items-center justify-center text-[#F5A623] shrink-0 group-hover:scale-105 transition-transform">
          <ShieldCheck :size="26" />
        </div>
        <div>
          <h3 class="text-white font-bold text-base sm:text-lg mb-1.5 tracking-tight">Certificação e Qualidade</h3>
          <p class="text-emerald-100/70 text-xs leading-relaxed">
            Produtos frescos cultivados por cooperados locais que respeitam a biodiversidade e o solo amazônico.
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Fish, Truck, ShieldCheck } from 'lucide-vue-next';
</script>

<style scoped>
@keyframes boxesFadeUp {
  0% {
    opacity: 0;
    transform: translateY(32px);
  }
  100% {
    opacity: 1;
    transform: translateY(0);
  }
}

.feature-box-1 {
  opacity: 0;
  animation: boxesFadeUp 0.85s cubic-bezier(0.16, 1, 0.3, 1) 0.82s forwards;
}

.feature-box-2 {
  opacity: 0;
  animation: boxesFadeUp 0.85s cubic-bezier(0.16, 1, 0.3, 1) 0.98s forwards;
}

.feature-box-3 {
  opacity: 0;
  animation: boxesFadeUp 0.85s cubic-bezier(0.16, 1, 0.3, 1) 1.14s forwards;
}
</style>
