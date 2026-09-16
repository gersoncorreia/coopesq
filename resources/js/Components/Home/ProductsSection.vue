<template>
  <section id="produtos" class="py-16 sm:py-28 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-12">
      <!-- Header no padrão Khela -->
      <div v-reveal class="text-center max-w-3xl mx-auto mb-10 sm:mb-14">
        <span class="text-xs font-bold text-[#F5A623] uppercase tracking-[0.25em] block mb-2">
          Our Portfolio • Catálogo de Produtos
        </span>
        <h2 class="font-display text-2xl sm:text-4xl font-extrabold text-slate-900 uppercase tracking-tight">
          PRODUTOS DA <span class="text-[#1B5E20]">AMAZÔNIA</span>
        </h2>
        <div class="w-12 h-1 bg-[#1B5E20] mx-auto mt-4 rounded-full"></div>
      </div>

      <!-- Khela Style Category Tabs (Horizontally scrollable chips on mobile, centered wrap on desktop) -->
      <div v-reveal class="flex items-center overflow-x-auto no-scrollbar sm:flex-wrap sm:justify-center gap-2 sm:gap-3 mb-10 sm:mb-14 pb-2 sm:pb-0 -mx-4 px-4 sm:mx-0 sm:px-0">
        <button 
          v-for="cat in categories" 
          :key="cat.slug"
          @click="$emit('select-category', cat.slug)"
          :class="activeCategory === cat.slug 
            ? 'bg-[#1B5E20] text-white shadow-md shadow-emerald-950/20' 
            : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
          class="px-4 sm:px-5 py-2 rounded-md font-bold text-xs uppercase tracking-wider transition-all duration-200 shrink-0 whitespace-nowrap"
        >
          {{ cat.label }}
        </button>
      </div>

      <!-- Products grid Khela Style -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div 
          v-for="(product, index) in products" 
          :key="product.id" 
          v-reveal
          :class="`delay-${(index % 4 + 1) * 100}`"
          class="reveal-scale group bg-white rounded-xl overflow-hidden border border-slate-200 shadow-xs hover:shadow-xl hover:border-[#1B5E20]/40 transition-all duration-300 card-lift flex flex-col justify-between"
        >
          <!-- Image area -->
          <div>
            <div class="relative h-52 bg-slate-100 flex items-center justify-center overflow-hidden">
              <img 
                v-if="product.image" 
                :src="product.image" 
                :alt="product.name" 
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                @error="(e) => e.target.style.display = 'none'"
              />
              <div v-if="!product.image" class="text-6xl select-none group-hover:scale-110 transition-transform">
                {{ getProductEmoji(product.name) }}
              </div>
              <div class="absolute top-3 left-3">
                <span class="bg-[#1B5E20] text-white text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded shadow-xs">
                  {{ product.category ? product.category.name : 'Geral' }}
                </span>
              </div>
            </div>

            <!-- Content -->
            <div class="p-5">
              <h3 class="font-bold text-slate-900 text-base mb-1.5 group-hover:text-[#1B5E20] transition-colors leading-snug">
                {{ product.name }}
              </h3>
              <p class="text-slate-500 text-xs line-clamp-2 leading-relaxed">
                {{ product.description }}
              </p>
            </div>
          </div>

          <!-- Action Button -->
          <div class="p-5 pt-0">
            <a 
              :href="`https://wa.me/5568999274776?text=Olá! Tenho interesse no produto: ${encodeURIComponent(product.name)}`" 
              target="_blank"
              class="flex items-center justify-center gap-2 w-full bg-slate-900 hover:bg-[#1B5E20] text-white font-bold py-2.5 rounded-md text-xs uppercase tracking-wider transition-colors shadow-xs"
            >
              <svg class="w-4 h-4 text-[#F5A623]" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
              <span>Solicitar Cotação</span>
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

<style scoped>
.no-scrollbar::-webkit-scrollbar { display: none; }
.no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
