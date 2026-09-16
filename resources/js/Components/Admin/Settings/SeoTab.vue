<template>
  <div class="divide-y divide-zinc-200/80">
    <!-- Seção 1: Indexação de Busca -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 py-6 first:pt-0">
      <div class="space-y-1">
        <h3 class="text-sm font-bold text-zinc-900 flex items-center gap-2">
          <Search :size="16" class="text-[#1B5E20]" />
          <span>Indexação & Motores de Busca</span>
        </h3>
        <p class="text-xs text-zinc-500 leading-relaxed">
          Títulos e descrições otimizados para exibição em resultados de busca no Google.
        </p>
      </div>

      <div class="md:col-span-2 space-y-4 max-w-2xl">
        <div>
          <label class="block text-xs font-semibold text-zinc-700 mb-1.5">Meta Title Padrão</label>
          <input 
            v-model="form.meta_title" 
            type="text" 
            class="w-full h-9 px-3 rounded-md border border-zinc-200 bg-white text-xs font-medium text-zinc-900 focus:ring-1 focus:ring-[#1B5E20] focus:border-[#1B5E20] focus:outline-none shadow-2xs" 
          />
        </div>

        <div>
          <label class="block text-xs font-semibold text-zinc-700 mb-1.5">Meta Description Padrão</label>
          <textarea 
            v-model="form.meta_description" 
            rows="3" 
            class="w-full p-3 rounded-md border border-zinc-200 bg-white text-xs text-zinc-800 focus:ring-1 focus:ring-[#1B5E20] focus:border-[#1B5E20] focus:outline-none leading-relaxed shadow-2xs resize-y"
          ></textarea>
        </div>

        <div>
          <label class="block text-xs font-semibold text-zinc-700 mb-1.5">Palavras-chave (Keywords separadas por vírgula)</label>
          <input 
            v-model="form.meta_keywords" 
            type="text" 
            class="w-full h-9 px-3 rounded-md border border-zinc-200 bg-white text-xs font-mono text-zinc-800 focus:ring-1 focus:ring-[#1B5E20] focus:border-[#1B5E20] focus:outline-none shadow-2xs" 
          />
        </div>
      </div>
    </div>

    <!-- Seção 2: Prévia no Google Search -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 py-6">
      <div class="space-y-1">
        <h3 class="text-sm font-bold text-zinc-900 flex items-center gap-2">
          <Globe :size="16" class="text-[#1B5E20]" />
          <span>Prévia SERP (Google)</span>
        </h3>
        <p class="text-xs text-zinc-500 leading-relaxed">
          Simulação de como o snippet do portal será renderizado em pesquisas orgânicas.
        </p>
      </div>

      <div class="md:col-span-2 max-w-2xl">
        <div class="p-4 rounded-md border border-zinc-200 bg-white shadow-2xs space-y-1">
          <div class="flex items-center gap-1.5 text-[11px] text-zinc-500">
            <span class="w-3.5 h-3.5 rounded-full bg-emerald-100 text-emerald-800 font-bold flex items-center justify-center text-[9px]">C</span>
            <span>https://coopesq.com.br</span>
          </div>
          <h4 class="text-sm font-medium text-[#1a0dab] hover:underline cursor-pointer line-clamp-1">
            {{ form.meta_title || 'COOPESQ - Cooperativa de Piscicultura e Produtos da Amazônia' }}
          </h4>
          <p class="text-xs text-zinc-600 line-clamp-2 leading-relaxed">
            {{ form.meta_description || 'Cooperativa de Piscicultura e Produtos Naturais da Amazônia. Fortalecendo a produção sustentável.' }}
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Search, Globe } from 'lucide-vue-next';

defineProps({ form: { type: Object, required: true } });
</script>
