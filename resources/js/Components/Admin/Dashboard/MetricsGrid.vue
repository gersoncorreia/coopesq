<template>
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <!-- Metric 1: Produtos -->
    <div class="bg-white p-4 rounded-lg border border-zinc-200/80 shadow-xs space-y-3 hover:border-[#1B5E20]/30 transition-colors">
      <div class="flex items-center justify-between">
        <span class="text-xs font-medium text-zinc-500">Produtos no Catálogo</span>
        <div class="w-6 h-6 rounded bg-emerald-50 text-[#1B5E20] flex items-center justify-center">
          <Package :size="14" />
        </div>
      </div>
      <div class="flex items-baseline justify-between">
        <span class="text-2xl font-bold tracking-tight text-zinc-900">
          {{ stats.total_products || 0 }}
        </span>
        <span class="text-[11px] font-medium text-emerald-800 bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-200/60">
          {{ stats.active_products || 0 }} ativos
        </span>
      </div>
      <div class="w-full bg-zinc-100 h-1.5 rounded-full overflow-hidden">
        <div 
          class="bg-[#1B5E20] h-full rounded-full transition-all duration-300" 
          :style="{ width: stats.total_products ? `${Math.min((stats.active_products / stats.total_products) * 100, 100)}%` : '0%' }"
        ></div>
      </div>
    </div>

    <!-- Metric 2: Notícias / Blog -->
    <div class="bg-white p-4 rounded-lg border border-zinc-200/80 shadow-xs space-y-3 hover:border-[#F5A623]/40 transition-colors">
      <div class="flex items-center justify-between">
        <span class="text-xs font-medium text-zinc-500">Matérias Publicadas</span>
        <div class="w-6 h-6 rounded bg-amber-50 text-[#d48b16] flex items-center justify-center">
          <FileText :size="14" />
        </div>
      </div>
      <div class="flex items-baseline justify-between">
        <span class="text-2xl font-bold tracking-tight text-zinc-900">
          {{ stats.published_posts || 0 }}
        </span>
        <span class="text-[11px] font-medium text-[#b36e05] bg-amber-50 px-1.5 py-0.5 rounded border border-amber-200/60">
          {{ stats.total_posts || 0 }} total
        </span>
      </div>
      <div class="w-full bg-zinc-100 h-1.5 rounded-full overflow-hidden">
        <div 
          class="bg-[#F5A623] h-full rounded-full transition-all duration-300" 
          :style="{ width: stats.total_posts ? `${Math.min((stats.published_posts / stats.total_posts) * 100, 100)}%` : '0%' }"
        ></div>
      </div>
    </div>

    <!-- Metric 3: Audiência / Leituras -->
    <div class="bg-white p-4 rounded-lg border border-zinc-200/80 shadow-xs space-y-3 hover:border-emerald-300 transition-colors">
      <div class="flex items-center justify-between">
        <span class="text-xs font-medium text-zinc-500">Audiência no Blog</span>
        <div class="w-6 h-6 rounded bg-emerald-50 text-[#1B5E20] flex items-center justify-center">
          <Eye :size="14" />
        </div>
      </div>
      <div class="flex items-baseline justify-between">
        <span class="text-2xl font-bold tracking-tight text-zinc-900">
          {{ Number(stats.total_post_views || 0).toLocaleString('pt-BR') }}
        </span>
        <span class="text-[11px] font-medium text-zinc-500">
          leituras
        </span>
      </div>
      <div class="w-full bg-zinc-100 h-1.5 rounded-full overflow-hidden">
        <div class="bg-[#2e7d32] h-full rounded-full w-3/4"></div>
      </div>
    </div>

    <!-- Metric 4: Parceiros & Cooperativa -->
    <div class="bg-white p-4 rounded-lg border border-zinc-200/80 shadow-xs space-y-3 hover:border-[#F5A623]/40 transition-colors">
      <div class="flex items-center justify-between">
        <span class="text-xs font-medium text-zinc-500">Parceiros Institucionais</span>
        <div class="w-6 h-6 rounded bg-amber-50 text-[#d48b16] flex items-center justify-center">
          <Building2 :size="14" />
        </div>
      </div>
      <div class="flex items-baseline justify-between">
        <span class="text-2xl font-bold tracking-tight text-zinc-900">
          {{ stats.total_partners || 0 }}
        </span>
        <span class="text-[11px] font-medium text-[#b36e05] bg-amber-50 px-1.5 py-0.5 rounded border border-amber-200/60">
          {{ stats.total_testimonials || 0 }} depoimentos
        </span>
      </div>
      <div class="w-full bg-zinc-100 h-1.5 rounded-full overflow-hidden">
        <div class="bg-gradient-to-r from-[#1B5E20] to-[#F5A623] h-full rounded-full w-full"></div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Package, FileText, Eye, Building2 } from 'lucide-vue-next';

defineProps({
  stats: { type: Object, default: () => ({}) }
});
</script>
