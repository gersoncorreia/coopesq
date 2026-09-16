<template>
  <section ref="sectionRef" class="py-16 sm:py-20 bg-[#0d1f10] text-white relative overflow-hidden">
    <!-- Decorative background elements -->
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-[#1B5E20]/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-[#F5A623]/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 relative z-10">
      <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 sm:gap-10">
        <!-- Stat 1: Toneladas -->
        <div v-reveal class="text-center group">
          <div class="w-14 h-14 mx-auto mb-4 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-[#F5A623] group-hover:scale-110 transition-transform">
            <Fish :size="28" />
          </div>
          <div class="font-display text-4xl sm:text-5xl font-black text-white tracking-tight leading-none mb-2">
            {{ displayValues.stat1.toLocaleString('pt-BR') }}<span class="text-[#F5A623]">+</span>
          </div>
          <div class="text-xs sm:text-sm font-semibold text-emerald-300/80 uppercase tracking-widest">
            Toneladas / Ano
          </div>
          <p class="text-[11px] text-white/50 mt-1 max-w-[180px] mx-auto">Capacidade produtiva de pescados</p>
        </div>

        <!-- Stat 2: Famílias -->
        <div v-reveal class="text-center group">
          <div class="w-14 h-14 mx-auto mb-4 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-[#F5A623] group-hover:scale-110 transition-transform">
            <Users :size="28" />
          </div>
          <div class="font-display text-4xl sm:text-5xl font-black text-white tracking-tight leading-none mb-2">
            {{ displayValues.stat2 }}<span class="text-[#F5A623]">+</span>
          </div>
          <div class="text-xs sm:text-sm font-semibold text-emerald-300/80 uppercase tracking-widest">
            Famílias Cooperadas
          </div>
          <p class="text-[11px] text-white/50 mt-1 max-w-[180px] mx-auto">Fortalecimento comunitário</p>
        </div>

        <!-- Stat 3: Rastreabilidade -->
        <div v-reveal class="text-center group">
          <div class="w-14 h-14 mx-auto mb-4 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-[#F5A623] group-hover:scale-110 transition-transform">
            <ShieldCheck :size="28" />
          </div>
          <div class="font-display text-4xl sm:text-5xl font-black text-white tracking-tight leading-none mb-2">
            {{ displayValues.stat3 }}<span class="text-[#F5A623]">%</span>
          </div>
          <div class="text-xs sm:text-sm font-semibold text-emerald-300/80 uppercase tracking-widest">
            Rastreabilidade
          </div>
          <p class="text-[11px] text-white/50 mt-1 max-w-[180px] mx-auto">Do tanque à entrega final</p>
        </div>

        <!-- Stat 4: Produtos -->
        <div v-reveal class="text-center group">
          <div class="w-14 h-14 mx-auto mb-4 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-[#F5A623] group-hover:scale-110 transition-transform">
            <Building2 :size="28" />
          </div>
          <div class="font-display text-4xl sm:text-5xl font-black text-white tracking-tight leading-none mb-2">
            {{ displayValues.stat4 }}<span class="text-[#F5A623]">+</span>
          </div>
          <div class="text-xs sm:text-sm font-semibold text-emerald-300/80 uppercase tracking-widest">
            Linhas de Produtos
          </div>
          <p class="text-[11px] text-white/50 mt-1 max-w-[180px] mx-auto">Frescor e diversidade amazônica</p>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { Fish, Users, ShieldCheck, Building2 } from 'lucide-vue-next';

const sectionRef = ref(null);
const animated = ref(false);

const displayValues = ref({
  stat1: 0,
  stat2: 0,
  stat3: 0,
  stat4: 0,
});

const targets = {
  stat1: 1500,
  stat2: 85,
  stat3: 100,
  stat4: 14,
};

const animateNumbers = () => {
  if (animated.value) return;
  animated.value = true;
  const duration = 2000;
  const startTime = performance.now();

  const step = (currentTime) => {
    const elapsed = currentTime - startTime;
    const progress = Math.min(elapsed / duration, 1);
    // Easing out cubic
    const easeOut = 1 - Math.pow(1 - progress, 3);

    displayValues.value.stat1 = Math.floor(easeOut * targets.stat1);
    displayValues.value.stat2 = Math.floor(easeOut * targets.stat2);
    displayValues.value.stat3 = Math.floor(easeOut * targets.stat3);
    displayValues.value.stat4 = Math.floor(easeOut * targets.stat4);

    if (progress < 1) {
      requestAnimationFrame(step);
    } else {
      displayValues.value = { ...targets };
    }
  };

  requestAnimationFrame(step);
};

let observer = null;
onMounted(() => {
  observer = new IntersectionObserver((entries) => {
    if (entries[0].isIntersecting) {
      animateNumbers();
      observer.disconnect();
    }
  }, { threshold: 0.2 });

  if (sectionRef.value) {
    observer.observe(sectionRef.value);
  }
});

onUnmounted(() => {
  if (observer) observer.disconnect();
});
</script>
