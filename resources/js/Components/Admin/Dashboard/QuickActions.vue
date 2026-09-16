<template>
  <div class="bg-white p-5 rounded-lg border border-zinc-200/80 shadow-xs space-y-3">
    <div class="flex items-center justify-between pb-2 border-b border-zinc-100">
      <h2 class="text-xs font-semibold uppercase tracking-wider text-zinc-500">Ações Rápidas</h2>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
      <router-link
        to="/admin/products"
        class="p-3 rounded-md border border-zinc-200/70 hover:border-[#1B5E20]/40 hover:bg-emerald-50/20 transition-all flex items-center gap-3 group"
      >
        <div class="w-8 h-8 rounded bg-emerald-50 text-[#1B5E20] flex items-center justify-center group-hover:scale-105 transition-transform">
          <Package :size="15" />
        </div>
        <div class="text-left">
          <span class="text-xs font-semibold text-zinc-800 group-hover:text-[#1B5E20] transition-colors block">Novo Produto</span>
          <span class="text-[10px] text-zinc-400 block">Catálogo</span>
        </div>
      </router-link>

      <router-link
        to="/admin/posts"
        class="p-3 rounded-md border border-zinc-200/70 hover:border-[#F5A623]/50 hover:bg-amber-50/20 transition-all flex items-center gap-3 group"
      >
        <div class="w-8 h-8 rounded bg-amber-50 text-[#d48b16] flex items-center justify-center group-hover:scale-105 transition-transform">
          <FileText :size="15" />
        </div>
        <div class="text-left">
          <span class="text-xs font-semibold text-zinc-800 group-hover:text-[#d48b16] transition-colors block">Nova Notícia</span>
          <span class="text-[10px] text-zinc-400 block">Blog</span>
        </div>
      </router-link>

      <router-link
        to="/admin/banners"
        class="p-3 rounded-md border border-zinc-200/70 hover:border-[#1B5E20]/40 hover:bg-emerald-50/20 transition-all flex items-center gap-3 group"
      >
        <div class="w-8 h-8 rounded bg-emerald-50 text-[#1B5E20] flex items-center justify-center group-hover:scale-105 transition-transform">
          <Images :size="15" />
        </div>
        <div class="text-left">
          <span class="text-xs font-semibold text-zinc-800 group-hover:text-[#1B5E20] transition-colors block">Banners</span>
          <span class="text-[10px] text-zinc-400 block">Página Inicial</span>
        </div>
      </router-link>

      <router-link
        to="/admin/settings"
        class="p-3 rounded-md border border-zinc-200/70 hover:border-[#F5A623]/50 hover:bg-amber-50/20 transition-all flex items-center gap-3 group"
      >
        <div class="w-8 h-8 rounded bg-amber-50 text-[#d48b16] flex items-center justify-center group-hover:scale-105 transition-transform">
          <Settings :size="15" />
        </div>
        <div class="text-left">
          <span class="text-xs font-semibold text-zinc-800 group-hover:text-[#d48b16] transition-colors block">Configurações</span>
          <span class="text-[10px] text-zinc-400 block">SEO & Marca</span>
        </div>
      </router-link>
    </div>
  </div>
</template>

<script setup>
import { Package, FileText, Images, Settings } from 'lucide-vue-next';
</script>
