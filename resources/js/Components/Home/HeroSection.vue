<template>
  <section class="relative min-h-[92vh] flex items-center justify-center bg-[#071309] overflow-hidden">
    <!-- Background Slides with Smooth Crossfade -->
    <div 
      v-for="(banner, idx) in slides" 
      :key="banner.id || idx"
      class="absolute inset-0 transition-opacity duration-1000 ease-in-out"
      :class="idx === currentIndex ? 'opacity-100 z-0' : 'opacity-0 pointer-events-none -z-10'"
    >
      <img 
        v-if="banner.image"
        :src="banner.image" 
        :alt="banner.title || 'Banner COOPESQ'" 
        class="w-full h-full object-cover object-center transition-transform duration-7000 ease-out"
        :class="idx === currentIndex ? 'scale-105' : 'scale-100'"
        @error="(e) => e.target.style.display = 'none'"
      />
      <div class="absolute inset-0 bg-gradient-to-b from-[#071309]/85 via-[#0d1f10]/75 to-[#071309]/95"></div>
      <div class="absolute inset-0 bg-[#0d1f10]/40 mix-blend-multiply"></div>
    </div>

    <!-- Decorative ambient glow -->
    <div class="absolute top-1/3 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[350px] bg-[#1B5E20]/25 rounded-full blur-3xl pointer-events-none"></div>

    <!-- Active Slide Content with Fluid Mobile Scaling -->
    <div class="relative z-10 w-full max-w-4xl mx-auto px-5 sm:px-8 lg:px-12 py-20 sm:py-28 pt-28 sm:pt-36 pb-16 sm:pb-24 text-center">
      <Transition name="fade-slide" mode="out-in">
        <div v-if="currentSlide.title" :key="currentIndex" class="space-y-3 sm:space-y-4">
          <div class="mb-2 sm:mb-3 hero-tag">
            <span class="text-[11px] sm:text-sm font-bold text-[#F5A623] tracking-[0.2em] sm:tracking-[0.25em] uppercase drop-shadow-xs">
              {{ currentSlide.tag || 'SUSTENTABILIDADE • PISCICULTURA • AMAZÔNIA' }}
            </span>
          </div>

          <h1 class="hero-title font-display text-2xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight uppercase leading-[1.16] mb-3 sm:mb-5 drop-shadow-md">
            {{ currentSlide.title }}
          </h1>

          <p class="hero-subtitle text-xs sm:text-base text-white/90 max-w-2xl mx-auto leading-relaxed mb-6 sm:mb-8 font-normal drop-shadow-xs px-2 sm:px-0">
            {{ currentSlide.subtitle }}
          </p>

          <!-- Optional Action Button (only if defined on the banner) -->
          <div v-if="currentSlide.cta_text && currentSlide.cta_text.trim()" class="hero-cta flex items-center justify-center pt-1 sm:pt-2">
            <a 
              :href="currentSlide.cta_url || '#produtos'" 
              @click="handleCta(currentSlide.cta_url, 'produtos', $event)"
              class="w-full sm:w-auto min-w-[180px] sm:min-w-[200px] block px-6 sm:px-8 py-3 sm:py-3.5 rounded-md bg-[#1B5E20] hover:bg-[#154a19] text-white font-bold text-xs sm:text-sm uppercase tracking-wider transition-all duration-200 shadow-xl shadow-black/30 hover:scale-[1.02] text-center cursor-pointer"
            >
              {{ currentSlide.cta_text }}
            </a>
          </div>
        </div>
      </Transition>
    </div>

    <!-- Controls (arrows and dots) when multiple banners -->
    <HeroSlideControls 
      :slides="slides" 
      :current-index="currentIndex"
      @prev="prevSlide" 
      @next="nextSlide" 
      @go-to="goToSlide" 
    />

    <!-- Scroll hint when only 1 banner -->
    <div v-if="slides.length <= 1" class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 scroll-hint">
      <span class="text-white/30 text-xs font-medium tracking-widest uppercase">Scroll</span>
      <div class="w-px h-8 bg-gradient-to-b from-white/30 to-transparent"></div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted, watch } from 'vue';
import HeroSlideControls from './HeroSlideControls.vue';

const props = defineProps({
  banners: { type: [Array, Object], default: () => [] },
  isLoading: { type: Boolean, default: false },
});
const emit = defineEmits(['scroll-to']);

const currentIndex = ref(0);
let timer = null;

const defaultSlide = {
  id: 0,
  title: 'FORTALECENDO A PRODUÇÃO AMAZÔNICA',
  subtitle: 'Unimos piscicultores e produtores da Amazônia para levar pescados frescos, frutos e hortaliças com excelência e sustentabilidade direto para a sua mesa.',
  image: '',
  cta_text: '',
  cta_url: '',
  tag: 'SUSTENTABILIDADE • PISCICULTURA • AMAZÔNIA',
};

const slides = computed(() => {
  const list = Array.isArray(props.banners) ? props.banners : [];
  const active = list.filter(b => b && b.is_active !== false);
  if (active.length > 0) return active;
  if (props.isLoading) return [];
  return [defaultSlide];
});

const currentSlide = computed(() => slides.value[currentIndex.value] || (props.isLoading ? { title: '', subtitle: '', cta_text: '' } : defaultSlide));

const nextSlide = () => { currentIndex.value = (currentIndex.value + 1) % slides.value.length; resetTimer(); };
const prevSlide = () => { currentIndex.value = (currentIndex.value - 1 + slides.value.length) % slides.value.length; resetTimer(); };
const goToSlide = (idx) => { currentIndex.value = idx; resetTimer(); };

const startTimer = () => { if (slides.value.length > 1) timer = setInterval(nextSlide, 6000); };
const resetTimer = () => { if (timer) clearInterval(timer); startTimer(); };

const handleCta = (url, fallback, event) => {
  if (!url || url.startsWith('#')) {
    event.preventDefault();
    emit('scroll-to', url ? url.replace('#', '') : fallback);
  }
};

watch(() => props.banners, () => { currentIndex.value = 0; resetTimer(); }, { deep: true });
onMounted(startTimer);
onUnmounted(() => { if (timer) clearInterval(timer); });
</script>

<style scoped>
@keyframes heroFadeUp {
  0% { opacity: 0; transform: translateY(24px); }
  100% { opacity: 1; transform: translateY(0); }
}
.hero-tag { opacity: 0; animation: heroFadeUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) 0.1s forwards; }
.hero-title { opacity: 0; animation: heroFadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.28s forwards; }
.hero-subtitle { opacity: 0; animation: heroFadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.46s forwards; }
.hero-cta { opacity: 0; animation: heroFadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.64s forwards; }

.fade-slide-leave-active { transition: opacity 0.35s ease, transform 0.35s ease; }
.fade-slide-leave-to { opacity: 0; transform: translateY(-12px); }
</style>
