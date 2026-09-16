<template>
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
    <!-- Bloco 1: Últimos Produtos (2 colunas) -->
    <div class="lg:col-span-2 bg-white rounded-lg border border-zinc-200/80 shadow-xs overflow-hidden">
      <div class="px-5 py-4 border-b border-zinc-100 flex items-center justify-between">
        <div>
          <h3 class="text-xs font-semibold text-zinc-900">Últimos Produtos Registrados</h3>
          <p class="text-[11px] text-zinc-400">Atividades recentes no catálogo</p>
        </div>
        <router-link to="/admin/products" class="text-xs font-semibold text-[#1B5E20] hover:underline">
          Ver Catálogo Completo
        </router-link>
      </div>

      <div v-if="!products || products.length === 0" class="py-10 text-center text-xs text-zinc-400">
        Nenhum produto registrado.
      </div>

      <div v-else class="divide-y divide-zinc-100">
        <div 
          v-for="prod in products" 
          :key="prod.id" 
          class="px-5 py-3 flex items-center justify-between hover:bg-zinc-50/70 transition-colors"
        >
          <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded bg-emerald-50 text-[#1B5E20] flex items-center justify-center text-xs font-medium">
              <Package :size="14" />
            </div>
            <div>
              <h4 class="text-xs font-semibold text-zinc-800">{{ prod.name }}</h4>
              <span class="text-[11px] text-zinc-400">
                {{ prod.category ? prod.category.name : 'Geral' }}
              </span>
            </div>
          </div>
          <div class="flex items-center gap-3">
            <span 
              :class="prod.is_active ? 'bg-emerald-50 text-emerald-800 border-emerald-200/80' : 'bg-amber-50 text-[#b36e05] border-amber-200/80'"
              class="text-[10px] font-medium px-2 py-0.5 rounded border"
            >
              {{ prod.is_active ? 'Ativo' : 'Rascunho' }}
            </span>
            <span class="text-[11px] text-zinc-400 font-mono hidden sm:inline">
              {{ prod.created_at ? new Date(prod.created_at).toLocaleDateString('pt-BR') : '-' }}
            </span>
          </div>
        </div>
      </div>
    </div>

    <!-- Bloco 2: Status da Infraestrutura -->
    <div class="bg-white rounded-lg border border-zinc-200/80 shadow-xs p-5 flex flex-col justify-between space-y-4">
      <div>
        <div class="flex items-center justify-between pb-3 border-b border-zinc-100">
          <h3 class="text-xs font-semibold text-zinc-900">Infraestrutura & Ambiente</h3>
          <span class="w-2 h-2 rounded-full bg-emerald-500 ring-2 ring-emerald-100"></span>
        </div>

        <div class="mt-4 space-y-2.5 text-xs">
          <div class="flex items-center justify-between py-1.5 border-b border-zinc-100">
            <span class="text-zinc-500">Banco de Dados</span>
            <span class="font-medium text-zinc-800">MySQL 8.0</span>
          </div>
          <div class="flex items-center justify-between py-1.5 border-b border-zinc-100">
            <span class="text-zinc-500">Autenticação API</span>
            <span class="font-medium text-zinc-800">Sanctum Bearer</span>
          </div>
          <div class="flex items-center justify-between py-1.5 border-b border-zinc-100">
            <span class="text-zinc-500">Laravel Core</span>
            <span class="font-medium text-zinc-800">v{{ systemInfo.laravel_version || '12' }}</span>
          </div>
          <div class="flex items-center justify-between py-1.5">
            <span class="text-zinc-500">Runtime PHP</span>
            <span class="font-medium text-zinc-800">v{{ systemInfo.php_version || '8.3' }}</span>
          </div>
        </div>
      </div>

      <div class="pt-3 border-t border-zinc-100">
        <p class="text-[11px] text-zinc-400 font-medium">
          COOPESQ Cooperativa • Porto Acre - AC
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Package } from 'lucide-vue-next';

defineProps({
  products: { type: Array, default: () => [] },
  systemInfo: { type: Object, default: () => ({}) }
});
</script>
