<template>
  <section id="produtos" class="py-24 sm:py-28 bg-slate-50">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
      <!-- Header -->
      <div v-reveal class="flex flex-col md:flex-row md:items-end justify-between mb-12 sm:mb-16 gap-6">
        <div>
          <div class="flex items-center gap-3 mb-4">
            <div class="h-0.5 w-8 bg-coopesq-orange"></div>
            <span class="text-xs font-bold text-coopesq-orange uppercase tracking-widest">Catálogo</span>
          </div>
          <h2 class="font-display text-3xl sm:text-5xl font-bold text-slate-900 leading-tight">
            Nossos Produtos<br/>
            <span class="text-coopesq-green">Naturais</span>
          </h2>
        </div>
        <!-- Category filters -->
        <div class="flex flex-wrap gap-2">
          <button 
            v-for="cat in categories" :key="cat.slug"
            @click="$emit('select-category', cat.slug)"
            :class="activeCategory === cat.slug 
              ? 'bg-coopesq-green text-white shadow-lg shadow-green-800/20' 
              : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200'"
            class="px-5 py-2.5 rounded-xl font-semibold text-xs transition-all duration-200"
          >
            {{ cat.label }}
          </button>
        </div>
      </div>

      <!-- Products grid -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div 
          v-for="(product, index) in products" 
          :key="product.id" 
          v-reveal
          :class="`delay-${(index % 4 + 1) * 100}`"
          class="reveal-scale group bg-white rounded-3xl overflow-hidden border border-slate-200/80 card-lift"
        >
          <!-- Image area -->
          <div class="relative h-52 bg-gradient-to-br from-emerald-50 to-coopesq-green-pale flex items-center justify-center overflow-hidden">
            <div class="text-6xl group-hover:scale-110 transition-transform duration-500 select-none">
              {{ getProductEmoji(product.name) }}
            </div>
            <div class="absolute top-4 left-4">
              <span class="bg-coopesq-green/90 backdrop-blur-sm text-white text-xs font-bold px-3 py-1.5 rounded-full">
                {{ product.category ? product.category.name : 'Geral' }}
              </span>
            </div>
          </div>
          <!-- Content -->
          <div class="p-6">
            <h3 class="font-bold text-slate-900 text-base mb-2 group-hover:text-coopesq-green transition-colors leading-snug">
              {{ product.name }}
            </h3>
            <p class="text-slate-500 text-xs line-clamp-2 mb-5 leading-relaxed">
              {{ product.description }}
            </p>
            <a 
              :href="`https://wa.me/5568999274776?text=Olá! Tenho interesse no produto: ${encodeURIComponent(product.name)}`" 
              target="_blank"
              class="group/btn flex items-center justify-center gap-2 w-full bg-slate-900 hover:bg-coopesq-green text-white font-semibold py-3 rounded-2xl text-xs transition-all duration-300"
            >
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
              Solicitar Cotação
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { getProductEmoji } from '../../utils/iconHelpers';

defineProps({
  products: { type: Array, default: () => [] },
  categories: { type: Array, default: () => [] },
  activeCategory: { type: String, default: 'all' },
});

defineEmits(['select-category']);
</script>
