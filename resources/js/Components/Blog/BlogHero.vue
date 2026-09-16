<template>
  <section class="relative bg-[#071309] overflow-hidden pt-36 sm:pt-44 pb-14 sm:pb-20 text-white">
    <!-- Atmospheric Background with Forest Texture Overlay -->
    <div class="absolute inset-0 pointer-events-none">
      <img 
        src="https://images.unsplash.com/photo-1511497584788-87676104235f?auto=format&fit=crop&w=2000&q=80" 
        alt="Floresta e Rios da Amazônia" 
        class="w-full h-full object-cover opacity-20 scale-105"
      />
      <div class="absolute inset-0 bg-gradient-to-b from-[#071309]/95 via-[#0d1f10]/80 to-[#071309]"></div>
    </div>

    <!-- Glowing Ambient Accent -->
    <div class="absolute -top-24 left-1/2 -translate-x-1/2 w-[600px] h-[250px] bg-[#1B5E20]/25 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative z-10 max-w-5xl mx-auto px-6 sm:px-8 text-center">
      <!-- Breadcrumbs -->
      <nav class="flex items-center justify-center gap-2 text-xs font-semibold text-white/60 mb-5">
        <router-link to="/" class="hover:text-[#F5A623] transition-colors">Início</router-link>
        <span>/</span>
        <span v-if="!isArticle" class="text-[#F5A623]">Blog & Notícias</span>
        <template v-else>
          <router-link to="/blog" class="hover:text-[#F5A623] transition-colors">Blog</router-link>
          <span>/</span>
          <span class="text-[#F5A623] max-w-[240px] truncate">{{ breadcrumbTitle || 'Artigo' }}</span>
        </template>
      </nav>

      <!-- Badge Tag -->
      <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-[#1B5E20]/50 border border-emerald-500/30 text-[11px] font-bold tracking-[0.2em] uppercase text-[#F5A623] mb-4 shadow-sm">
        <span>{{ badge || 'COOPERATIVA AGROPECUÁRIA • COOPESQ' }}</span>
      </div>

      <!-- Main Title -->
      <h1 class="font-display text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight uppercase leading-tight mb-4 drop-shadow-md">
        <template v-if="title">{{ title }}</template>
        <template v-else>
          BLOG &amp; <span class="text-[#F5A623]">NOTÍCIAS</span> COOPESQ
        </template>
      </h1>

      <!-- Subtitle -->
      <p v-if="subtitle" class="text-sm sm:text-base text-white/80 max-w-2xl mx-auto leading-relaxed font-normal mb-8">
        {{ subtitle }}
      </p>

      <!-- Search Input Slot / Element -->
      <div v-if="showSearch" class="max-w-xl mx-auto mt-4">
        <form @submit.prevent="$emit('search', localSearch)" class="relative flex items-center">
          <input 
            type="text" 
            v-model="localSearch"
            placeholder="Pesquisar por notícias, inovações, piscicultura..."
            class="w-full pl-12 pr-28 py-3.5 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl text-white placeholder-white/50 text-sm focus:outline-hidden focus:border-[#F5A623] focus:bg-white/15 transition-all shadow-xl"
          />
          <svg class="w-5 h-5 text-white/50 absolute left-4 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
          </svg>
          <button 
            type="submit" 
            class="absolute right-2 px-4 py-2 bg-[#F5A623] hover:bg-[#e69512] text-slate-950 font-bold text-xs uppercase tracking-wider rounded-xl transition-all shadow-md"
          >
            Buscar
          </button>
        </form>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue';

const props = defineProps({
  badge: { type: String, default: '' },
  title: { type: String, default: '' },
  subtitle: { type: String, default: 'Acompanhe as publicações, artigos e inovações da produção sustentável e piscicultura amazônica.' },
  breadcrumbTitle: { type: String, default: '' },
  isArticle: { type: Boolean, default: false },
  showSearch: { type: Boolean, default: false },
});

defineEmits(['search']);
const localSearch = ref('');
</script>
