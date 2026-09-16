<template>
  <div 
    class="w-48 sm:w-56 shrink-0 flex flex-col items-center justify-center gap-3 px-4 py-3 group cursor-pointer select-none transition-all duration-300 hover:-translate-y-1"
    @click="handleClick"
  >
    <!-- Logo Container (Frameless, Clean) -->
    <div class="h-14 sm:h-16 w-full flex items-center justify-center relative">
      <img 
        v-if="partner.logo && !hasError" 
        :src="partner.logo" 
        :alt="partner.name" 
        class="max-h-12 sm:max-h-14 max-w-[150px] sm:max-w-[180px] w-auto h-auto object-contain filter grayscale opacity-65 group-hover:grayscale-0 group-hover:opacity-100 group-hover:scale-105 transition-all duration-300 drop-shadow-xs"
        @error="hasError = true"
      />
      <!-- Elegant fallback badge if image fails -->
      <div 
        v-else 
        class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-50 to-slate-100 border border-emerald-900/10 flex items-center justify-center text-[#1B5E20] group-hover:border-[#1B5E20]/40 group-hover:bg-[#1B5E20]/10 transition-all duration-300 shadow-2xs group-hover:scale-105"
      >
        <Building2 :size="22" class="text-[#1B5E20]/80 group-hover:text-[#1B5E20]" />
      </div>
    </div>

    <!-- Partner Name & Micro Accent (Clean Typography) -->
    <div class="flex flex-col items-center gap-1.5 w-full">
      <span class="text-xs sm:text-[13px] font-bold text-slate-700 group-hover:text-[#1B5E20] text-center line-clamp-2 leading-snug transition-colors duration-200 tracking-tight max-w-[180px]">
        {{ partner.name }}
      </span>
      <div class="w-0 group-hover:w-8 h-0.5 bg-[#F5A623] rounded-full transition-all duration-300"></div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { Building2 } from 'lucide-vue-next';

const props = defineProps({
  partner: { type: Object, required: true }
});

const hasError = ref(false);

const handleClick = () => {
  if (props.partner.url) {
    window.open(props.partner.url, '_blank', 'noopener,noreferrer');
  }
};
</script>
