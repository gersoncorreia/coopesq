<template>
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
    <!-- Bloco 1: Últimos Produtos -->
    <div class="bg-white rounded-lg border border-zinc-200/80 shadow-xs overflow-hidden flex flex-col justify-between">
      <div>
        <div class="px-5 py-4 border-b border-zinc-100 flex items-center justify-between">
          <div>
            <h3 class="text-xs font-semibold text-zinc-900">Últimos Produtos Registrados</h3>
            <p class="text-[11px] text-zinc-400">Atividades recentes no catálogo</p>
          </div>
          <router-link to="/admin/products" class="text-xs font-semibold text-[#1B5E20] hover:underline">
            Ver Catálogo
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
            <div class="flex items-center gap-3 min-w-0">
              <div class="w-8 h-8 rounded bg-emerald-50 text-[#1B5E20] flex items-center justify-center shrink-0">
                <Package :size="14" />
              </div>
              <div class="truncate">
                <h4 class="text-xs font-semibold text-zinc-800 truncate">{{ prod.name }}</h4>
                <span class="text-[11px] text-zinc-400">
                  {{ prod.category ? prod.category.name : 'Geral' }}
                </span>
              </div>
            </div>
            <div class="flex items-center gap-2.5 shrink-0 ml-3">
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
    </div>

    <!-- Bloco 2: Últimas Matérias do Blog -->
    <div class="bg-white rounded-lg border border-zinc-200/80 shadow-xs overflow-hidden flex flex-col justify-between">
      <div>
        <div class="px-5 py-4 border-b border-zinc-100 flex items-center justify-between">
          <div>
            <h3 class="text-xs font-semibold text-zinc-900">Últimas Publicações do Blog</h3>
            <p class="text-[11px] text-zinc-400">Artigos e notícias recentes</p>
          </div>
          <router-link to="/admin/posts" class="text-xs font-semibold text-[#1B5E20] hover:underline">
            Ver Notícias
          </router-link>
        </div>

        <div v-if="!posts || posts.length === 0" class="py-10 text-center text-xs text-zinc-400">
          Nenhuma publicação registrada.
        </div>

        <div v-else class="divide-y divide-zinc-100">
          <div 
            v-for="post in posts" 
            :key="post.id" 
            class="px-5 py-3 flex items-center justify-between hover:bg-zinc-50/70 transition-colors"
          >
            <div class="flex items-center gap-3 min-w-0">
              <div class="w-8 h-8 rounded bg-amber-50 text-[#b36e05] flex items-center justify-center shrink-0">
                <Newspaper :size="14" />
              </div>
              <div class="truncate">
                <h4 class="text-xs font-semibold text-zinc-800 truncate">{{ post.title }}</h4>
                <span class="text-[11px] text-zinc-400">
                  {{ post.category ? post.category.name : 'Geral' }} • {{ post.views || 0 }} leituras
                </span>
              </div>
            </div>
            <div class="flex items-center gap-2.5 shrink-0 ml-3">
              <span 
                :class="post.is_published ? 'bg-emerald-50 text-emerald-800 border-emerald-200/80' : 'bg-zinc-100 text-zinc-600 border-zinc-200'"
                class="text-[10px] font-medium px-2 py-0.5 rounded border"
              >
                {{ post.is_published ? 'Publicado' : 'Rascunho' }}
              </span>
              <span class="text-[11px] text-zinc-400 font-mono hidden sm:inline">
                {{ post.created_at ? new Date(post.created_at).toLocaleDateString('pt-BR') : '-' }}
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Package, Newspaper } from 'lucide-vue-next';

defineProps({
  products: { type: Array, default: () => [] },
  posts: { type: Array, default: () => [] },
});
</script>
