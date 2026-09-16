<template>
  <section id="parceiros" class="py-16 sm:py-20 bg-white border-y border-slate-100 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-12 mb-6 sm:mb-10">
      <div v-reveal class="flex flex-row items-end justify-between gap-4">
        <!-- Header institucional -->
        <div>
          <span class="text-xs font-bold text-[#F5A623] uppercase tracking-[0.25em] block mb-1.5 sm:mb-2">
            Trusted By • Nossos Parceiros
          </span>
          <h2 class="font-display text-xl sm:text-3xl font-extrabold text-slate-900 uppercase tracking-tight">
            QUEM CONFIA NA <span class="text-[#1B5E20]">COOPESQ</span>
          </h2>
          <div class="w-10 h-0.5 bg-[#1B5E20] mt-2.5 sm:mt-3 rounded-full"></div>
        </div>

        <!-- Controles Interativos do Carrossel -->
        <div class="flex items-center gap-1.5 sm:gap-2 shrink-0">
          <button 
            @click="scrollPrev"
            title="Voltar"
            class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-slate-100 hover:bg-[#1B5E20] text-slate-600 hover:text-white flex items-center justify-center transition-all duration-200 shadow-2xs hover:scale-105 active:scale-95 cursor-pointer"
          >
            <ChevronLeft :size="16" />
          </button>
          <button 
            @click="togglePause"
            :title="isManualPaused ? 'Retomar reprodução' : 'Pausar reprodução'"
            class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-slate-100 hover:bg-[#1B5E20] text-slate-600 hover:text-white flex items-center justify-center transition-all duration-200 shadow-2xs hover:scale-105 active:scale-95 cursor-pointer"
          >
            <Play v-if="isManualPaused" :size="14" class="ml-0.5" />
            <Pause v-else :size="14" />
          </button>
          <button 
            @click="scrollNext"
            title="Avançar"
            class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-slate-100 hover:bg-[#1B5E20] text-slate-600 hover:text-white flex items-center justify-center transition-all duration-200 shadow-2xs hover:scale-105 active:scale-95 cursor-pointer"
          >
            <ChevronRight :size="16" />
          </button>
        </div>
      </div>
    </div>

    <!-- Container do Carrossel Contínuo (Sem Cards) -->
    <div class="relative w-full overflow-hidden">
      <!-- Máscaras de gradiente nas bordas (efeito horizonte infinito) -->
      <div class="absolute left-0 inset-y-0 w-8 sm:w-28 bg-gradient-to-r from-white via-white/80 to-transparent pointer-events-none z-10"></div>
      <div class="absolute right-0 inset-y-0 w-8 sm:w-28 bg-gradient-to-l from-white via-white/80 to-transparent pointer-events-none z-10"></div>

      <!-- Trilho do Carrossel com suporte a Drag & Auto-Scroll -->
      <div 
        ref="trackRef"
        class="flex items-center overflow-x-auto no-scrollbar py-4 cursor-grab active:cursor-grabbing select-none"
        @mouseenter="isHovered = true"
        @mouseleave="onMouseLeave"
        @mousedown="onMouseDown"
        @mousemove="onMouseMove"
        @mouseup="onMouseUp"
      >
        <PartnerLogoItem 
          v-for="(partner, idx) in carouselItems" 
          :key="`${partner.id}-${idx}`"
          :partner="partner"
        />
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { ChevronLeft, ChevronRight, Play, Pause } from 'lucide-vue-next';
import PartnerLogoItem from './PartnerLogoItem.vue';

const props = defineProps({
  partners: { type: [Array, Object], default: () => [] },
});

const trackRef = ref(null);
const isHovered = ref(false);
const isManualPaused = ref(false);
const isDragging = ref(false);
const startX = ref(0);
const scrollStart = ref(0);
let rafId = null;

const carouselItems = computed(() => {
  const list = Array.isArray(props.partners) ? props.partners : [];
  if (!list.length) return [];
  return [...list, ...list, ...list];
});

const scrollSpeed = 0.75;

const tick = () => {
  if (trackRef.value && !isHovered.value && !isManualPaused.value && !isDragging.value) {
    trackRef.value.scrollLeft += scrollSpeed;
    const oneThird = trackRef.value.scrollWidth / 3;
    if (trackRef.value.scrollLeft >= oneThird * 2) {
      trackRef.value.scrollLeft -= oneThird;
    }
  }
  rafId = requestAnimationFrame(tick);
};

const scrollPrev = () => trackRef.value?.scrollBy({ left: -280, behavior: 'smooth' });
const scrollNext = () => trackRef.value?.scrollBy({ left: 280, behavior: 'smooth' });
const togglePause = () => { isManualPaused.value = !isManualPaused.value; };

const onMouseDown = (e) => {
  isDragging.value = true;
  startX.value = e.pageX - trackRef.value.offsetLeft;
  scrollStart.value = trackRef.value.scrollLeft;
};
const onMouseMove = (e) => {
  if (!isDragging.value) return;
  e.preventDefault();
  const x = e.pageX - trackRef.value.offsetLeft;
  trackRef.value.scrollLeft = scrollStart.value - (x - startX.value) * 1.5;
};
const onMouseUp = () => { isDragging.value = false; };
const onMouseLeave = () => { isHovered.value = false; isDragging.value = false; };

onMounted(() => { rafId = requestAnimationFrame(tick); });
onUnmounted(() => { if (rafId) cancelAnimationFrame(rafId); });
</script>

<style scoped>
.no-scrollbar::-webkit-scrollbar { display: none; }
.no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
