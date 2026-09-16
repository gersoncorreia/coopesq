<template>
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-zinc-200/80">
    <div>
      <div class="flex items-center gap-2 mb-1">
        <h1 class="text-xl font-bold tracking-tight text-zinc-900">Visão Geral</h1>
        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
          <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
          Sistema Operacional
        </span>
      </div>
      <p class="text-xs text-zinc-500">
        Monitoramento operacional, métricas de conteúdo e indicadores do ecossistema COOPESQ.
      </p>
    </div>

    <div class="flex items-center gap-2">
      <router-link
        to="/admin/products"
        class="h-8 px-3 rounded-md text-xs font-medium bg-[#1B5E20] hover:bg-[#144718] text-white shadow-xs transition-colors inline-flex items-center gap-1.5"
      >
        <Plus :size="14" />
        <span>Novo Produto</span>
      </router-link>
    </div>
  </div>
</template>

<script setup>
import { Plus } from 'lucide-vue-next';

defineProps({
  systemInfo: { type: Object, default: () => ({}) }
});
</script>
