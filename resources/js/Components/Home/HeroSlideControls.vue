<template>
  <div v-if="slides.length > 1">
    <!-- Prev Arrow -->
    <button 
      @click="$emit('prev')" 
      aria-label="Banner anterior"
      class="absolute left-2 sm:left-8 top-1/2 -translate-y-1/2 z-20 w-8 h-8 sm:w-11 sm:h-11 rounded-full bg-black/35 hover:bg-[#1B5E20] text-white/80 hover:text-white border border-white/10 flex items-center justify-center backdrop-blur-md transition-all duration-200 hover:scale-110 cursor-pointer shadow-lg"
    >
      <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
      </svg>
    </button>

    <!-- Next Arrow -->
    <button 
      @click="$emit('next')" 
      aria-label="Próximo banner"
      class="absolute right-2 sm:right-8 top-1/2 -translate-y-1/2 z-20 w-8 h-8 sm:w-11 sm:h-11 rounded-full bg-black/35 hover:bg-[#1B5E20] text-white/80 hover:text-white border border-white/10 flex items-center justify-center backdrop-blur-md transition-all duration-200 hover:scale-110 cursor-pointer shadow-lg"
    >
      <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
      </svg>
    </button>

    <!-- Dots Indicators -->
    <div class="absolute bottom-8 sm:bottom-12 left-1/2 -translate-x-1/2 z-20 flex items-center gap-1.5 sm:gap-2">
      <button 
        v-for="(_, i) in slides" 
        :key="i"
        @click="$emit('go-to', i)"
        :aria-label="`Ir para banner ${i + 1}`"
        class="h-1.5 sm:h-2 rounded-full transition-all duration-300 cursor-pointer"
        :class="i === currentIndex ? 'w-6 sm:w-8 bg-[#F5A623]' : 'w-2 sm:w-2.5 bg-white/40 hover:bg-white/70'"
      ></button>
    </div>
  </div>
</template>

<script setup>
defineProps({
  slides: { type: Array, required: true },
  currentIndex: { type: Number, required: true },
});

defineEmits(['prev', 'next', 'go-to']);
</script>
