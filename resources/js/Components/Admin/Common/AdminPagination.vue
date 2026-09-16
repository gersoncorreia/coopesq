<template>
  <div v-if="totalPages > 1" class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-4 border-t border-zinc-200/80 text-xs text-zinc-500">
    <div>
      Mostrando <span class="font-semibold text-zinc-800">{{ startIndex }}</span> a <span class="font-semibold text-zinc-800">{{ endIndex }}</span> de <span class="font-semibold text-zinc-800">{{ total }}</span> registros
    </div>

    <div class="flex items-center gap-1.5 self-center sm:self-auto">
      <button 
        @click="setPage(currentPage - 1)" 
        :disabled="currentPage <= 1"
        class="h-8 px-2.5 rounded-md border border-zinc-200 bg-white hover:bg-zinc-50 text-zinc-700 disabled:opacity-40 disabled:cursor-not-allowed transition-colors flex items-center gap-1 font-medium cursor-pointer"
        title="Página anterior"
      >
        <ChevronLeft :size="14" />
        <span class="hidden sm:inline text-[11px]">Anterior</span>
      </button>

      <div class="flex items-center gap-1">
        <button
          v-for="p in visiblePages"
          :key="p"
          @click="setPage(p)"
          :class="p === currentPage 
            ? 'bg-[#1B5E20] text-white font-bold border-[#1B5E20]' 
            : 'bg-white text-zinc-700 hover:bg-zinc-50 border-zinc-200 font-medium'"
          class="h-8 min-w-[32px] px-2 rounded-md border text-xs transition-colors cursor-pointer"
        >
          {{ p }}
        </button>
      </div>

      <button 
        @click="setPage(currentPage + 1)" 
        :disabled="currentPage >= totalPages"
        class="h-8 px-2.5 rounded-md border border-zinc-200 bg-white hover:bg-zinc-50 text-zinc-700 disabled:opacity-40 disabled:cursor-not-allowed transition-colors flex items-center gap-1 font-medium cursor-pointer"
        title="Próxima página"
      >
        <span class="hidden sm:inline text-[11px]">Próxima</span>
        <ChevronRight :size="14" />
      </button>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { ChevronLeft, ChevronRight } from 'lucide-vue-next';

const props = defineProps({
  total: { type: Number, default: 0 },
  perPage: { type: Number, default: 8 },
  currentPage: { type: Number, default: 1 }
});

const emit = defineEmits(['update:currentPage']);

const totalPages = computed(() => Math.max(1, Math.ceil(props.total / props.perPage)));
const startIndex = computed(() => (props.total === 0 ? 0 : (props.currentPage - 1) * props.perPage + 1));
const endIndex = computed(() => Math.min(props.total, props.currentPage * props.perPage));

const visiblePages = computed(() => {
  const pages = [];
  const start = Math.max(1, props.currentPage - 2);
  const end = Math.min(totalPages.value, start + 4);
  for (let i = start; i <= end; i++) {
    pages.push(i);
  }
  return pages;
});

const setPage = (page) => {
  if (page >= 1 && page <= totalPages.value) {
    emit('update:currentPage', page);
  }
};
</script>
