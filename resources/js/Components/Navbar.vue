<template>
  <header class="sticky top-0 z-50 transition-all duration-300" :class="scrolled ? 'bg-coopesq-dark/95 backdrop-blur-xl shadow-2xl shadow-black/20' : 'bg-transparent'">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
      <div class="flex items-center justify-between h-20">
        <!-- Logo Brand -->
        <router-link to="/" class="flex items-center space-x-3 group">
          <div class="relative">
            <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-coopesq-orange to-amber-400 flex items-center justify-center font-black text-white text-lg shadow-lg group-hover:scale-105 transition-all duration-300">
              C
            </div>
            <div class="absolute -top-0.5 -right-0.5 w-3 h-3 bg-emerald-400 rounded-full border-2 border-coopesq-dark"></div>
          </div>
          <div>
            <span class="font-black text-xl tracking-wide block text-white">COOPESQ</span>
            <span class="text-xs text-emerald-300/70 font-medium hidden sm:block tracking-widest uppercase">Cooperativa Amazônica</span>
          </div>
        </router-link>

        <!-- Desktop Navigation -->
        <nav class="hidden md:flex items-center space-x-1 text-sm font-semibold">
          <router-link to="/" class="px-4 py-2 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-all duration-200">Início</router-link>
          <a href="#sobre" @click.prevent="scrollTo('sobre')" class="px-4 py-2 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-all duration-200">Sobre</a>
          <a href="#produtos" @click.prevent="scrollTo('produtos')" class="px-4 py-2 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-all duration-200">Produtos</a>
          <a href="#parceiros" @click.prevent="scrollTo('parceiros')" class="px-4 py-2 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-all duration-200">Parceiros</a>
          <router-link to="/blog" class="px-4 py-2 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-all duration-200">Blog</router-link>
          <a href="#contato" @click.prevent="scrollTo('contato')" class="px-4 py-2 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-all duration-200">Contato</a>
        </nav>

        <!-- CTA Button -->
        <div class="hidden md:flex items-center gap-3">
          <a href="https://wa.me/5568999274776" target="_blank" class="flex items-center gap-2 text-sm font-semibold text-emerald-300 hover:text-emerald-200 transition-colors px-3 py-2 rounded-xl hover:bg-white/10">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            WhatsApp
          </a>
          <router-link 
            to="/admin/login" 
            class="bg-coopesq-orange hover:bg-amber-400 text-slate-900 font-bold px-5 py-2.5 rounded-xl transition-all duration-200 shadow-lg shadow-amber-500/20 hover:shadow-amber-500/40 text-sm"
          >
            Área Restrita
          </router-link>
        </div>

        <!-- Mobile menu button -->
        <button @click="isOpen = !isOpen" class="md:hidden text-white hover:text-coopesq-orange transition-colors p-2 rounded-xl hover:bg-white/10">
          <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path v-if="!isOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>
    </div>

    <!-- Mobile menu -->
    <Transition name="slide-down">
      <div v-if="isOpen" class="md:hidden bg-coopesq-dark/98 backdrop-blur-xl border-t border-white/10 px-4 pt-4 pb-6 space-y-1">
        <router-link to="/" class="block px-4 py-3 text-white/80 font-semibold rounded-xl hover:bg-white/10 hover:text-white transition-all">Início</router-link>
        <a href="#sobre" @click="isOpen = false" class="block px-4 py-3 text-white/80 font-semibold rounded-xl hover:bg-white/10 hover:text-white transition-all">Sobre Nós</a>
        <a href="#produtos" @click="isOpen = false" class="block px-4 py-3 text-white/80 font-semibold rounded-xl hover:bg-white/10 hover:text-white transition-all">Produtos</a>
        <router-link to="/blog" class="block px-4 py-3 text-white/80 font-semibold rounded-xl hover:bg-white/10 hover:text-white transition-all">Blog</router-link>
        <a href="#contato" @click="isOpen = false" class="block px-4 py-3 text-white/80 font-semibold rounded-xl hover:bg-white/10 hover:text-white transition-all">Contato</a>
        <div class="pt-3 border-t border-white/10 mt-3">
          <router-link to="/admin/login" class="flex items-center justify-center gap-2 bg-coopesq-orange text-slate-900 font-bold px-4 py-3 rounded-xl text-sm shadow-lg">
            Área Restrita
          </router-link>
        </div>
      </div>
    </Transition>
  </header>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

const isOpen = ref(false);
const scrolled = ref(false);

const handleScroll = () => {
  scrolled.value = window.scrollY > 50;
};

const scrollTo = (id) => {
  const el = document.getElementById(id);
  if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
  isOpen.value = false;
};

onMounted(() => window.addEventListener('scroll', handleScroll));
onUnmounted(() => window.removeEventListener('scroll', handleScroll));
</script>

<style scoped>
.slide-down-enter-active,
.slide-down-leave-active {
  transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
}
.slide-down-enter-from,
.slide-down-leave-to {
  opacity: 0;
  transform: translateY(-8px);
}
</style>
