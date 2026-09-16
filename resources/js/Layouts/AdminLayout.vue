<template>
  <div class="min-h-screen bg-[#f4f5f7] flex font-sans antialiased text-zinc-800 relative">
    <!-- Backdrop Overlay on Mobile -->
    <Transition name="fade">
      <div 
        v-if="isMobileMenuOpen" 
        @click="isMobileMenuOpen = false" 
        class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs z-20 md:hidden transition-opacity"
      ></div>
    </Transition>

    <!-- Sidebar Wrapper (Drawer on Mobile, Static on Desktop) -->
    <div 
      class="fixed inset-y-0 left-0 z-30 transform transition-transform duration-300 ease-in-out md:relative md:transform-none"
      :class="isMobileMenuOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'"
    >
      <AdminSidebar @close="isMobileMenuOpen = false" />
    </div>

    <!-- Content Workspace -->
    <div class="flex-1 flex flex-col min-w-0 w-full">
      <header class="h-14 bg-white border-b border-zinc-200 px-4 sm:px-6 flex justify-between items-center sticky top-0 z-10 shadow-2xs">
        <div class="flex items-center gap-3">
          <!-- Mobile Hamburger Toggle -->
          <button 
            @click="isMobileMenuOpen = !isMobileMenuOpen" 
            class="md:hidden p-1.5 rounded-lg text-zinc-600 hover:text-zinc-900 hover:bg-zinc-100 transition-colors cursor-pointer"
            title="Abrir navegação"
          >
            <Menu :size="18" />
          </button>
          <div class="flex items-center gap-2 text-xs text-zinc-500">
            <span class="font-bold text-[#1B5E20]">COOPESQ</span>
            <span class="text-zinc-300">/</span>
            <span class="font-semibold text-zinc-800 truncate max-w-[140px] sm:max-w-none">Console Administrativo</span>
          </div>
        </div>

        <div class="flex items-center gap-2 sm:gap-3">
          <router-link 
            to="/" 
            target="_blank" 
            class="h-8 px-2.5 sm:px-3 rounded-md text-xs font-medium text-zinc-700 hover:text-[#1B5E20] hover:border-[#1B5E20]/30 bg-white hover:bg-emerald-50/40 border border-zinc-200 transition-colors flex items-center gap-1.5 cursor-pointer"
          >
            <ExternalLink :size="13" />
            <span class="hidden sm:inline">Ver Portal Público</span>
          </router-link>
        </div>
      </header>

      <main class="flex-1 p-4 sm:p-6 md:p-8 max-w-7xl w-full mx-auto overflow-y-auto">
        <slot></slot>
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { Menu, ExternalLink } from 'lucide-vue-next';
import AdminSidebar from '../Components/Admin/AdminSidebar.vue';
import { useSettingsStore } from '../stores/useSettingsStore';

const settingsStore = useSettingsStore();
const isMobileMenuOpen = ref(false);

onMounted(() => {
  if (!settingsStore.loaded) {
    settingsStore.fetchSettings();
  }
});
</script>

<style scoped>
.fade-enter-active, .fade-leave-active { transition: opacity 0.2s ease; }
.fade-enter-from, .fade-leave-to { opacity: 0; }
</style>
